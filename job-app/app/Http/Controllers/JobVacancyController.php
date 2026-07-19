<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyRequest;
use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\Resume;
use App\Services\ResumeAnalysisService;

class JobVacancyController extends Controller
{
    protected $resumeAnalysisService;

    public function __construct(ResumeAnalysisService $resumeAnalysisService)
    {
        $this->resumeAnalysisService = $resumeAnalysisService;
    }

    public function show(string $id)
    {
        $vacancy = JobVacancy::find($id);

        return view('job-vacancy.show', compact('vacancy'));
    }

    public function apply(string $id)
    {
        $vacancy = JobVacancy::find($id);
        $resumes = auth()->user()->resumes;

        return view('job-vacancy.apply', compact('vacancy', 'resumes'));
    }

    public function storeApplication(ApplyRequest $request, string $id)
    {
        $vacancy = JobVacancy::findOrFail($id);
        $resumeId = null;
        $extractedInfo = null;

        if ($request->input('resume_option') === 'new_resume') {
            $file = $request->file('resume_file');
            $extension = $file->getClientOriginalExtension();
            $originalFileName = $file->getClientOriginalName();
            $fileName = 'resume_'.time().'.'.$extension;

            // store the file in the cloud disk

            $path = $file->storeAs('resumes', $fileName, 'cloud');

            $fileUrl = config('filesystems.disks.cloud.url').'/'.$path;
            $extractedInfo = $this->resumeAnalysisService->extractResumeInfo($fileUrl);

            $resume = Resume::create([
                'userId' => auth()->id(),
                'fileUrl' => $path,
                'fileName' => $originalFileName,
                'contactDetails' => $extractedInfo['contactDetails'],
                'summary' => $extractedInfo['summary'],
                'education' => $extractedInfo['education'],
                'skills' => $extractedInfo['skills'] ?? '',
                'experience' => $extractedInfo['experience'],
            ]);

            $resumeId = $resume->id;

        } else {
            $resumeId = str_replace('existing_', '', $request->input('resume_option'));
            $resume = Resume::find($resumeId);
            $extractedInfo = [
                'summary' => $resume->summary,
                'education' => $resume->education,
                'skills' => $resume->skills,
                'experience' => $resume->experience,
            ];
        }

        $evaluationResult = $this->resumeAnalysisService->analyzeResume($vacancy, $extractedInfo);
        JobApplication::create([
            'userId' => auth()->id(),
            'jobVacancyId' => $vacancy->id,
            'resumeId' => $resumeId,
            'status' => 'pending',
            'aiGeneratedScore' => $evaluationResult['AiGeneratedScore'],
            'aiGeneratedFeedback' => $evaluationResult['AiGeneratedFeedback'],
        ]);

        return redirect()->route('job-applications.index')->with('success', 'Application Submitted Successfully');

    }
}
