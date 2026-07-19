<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use OpenAI\Laravel\Facades\OpenAI;
use Spatie\PdfToText\Pdf;

use function is_array;
use function strlen;

class ResumeAnalysisService
{
    public function extractResumeInfo(string $fileUrl)
    {
        try {
            // extract raw text from the resume pdf file
            $rawText = $this->extractTextFromPdf($fileUrl);

            Log::debug('Successfully extracted text from pdf: '.strlen($rawText));
            // Use AI API to organize the text into structured information
            $response = OpenAI::chat()->create([
                'model' => 'gpt-5.6-luna',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a Percise resume parser. Extract Information exactily as it without adding any interpretation or additional information.
                    Given the raw text of a resume, extract the following information and return it in JSON format:
                    - Summary
                    - Education
                    - Skills
                    - Experience
                    - Contact Details (name, email, phone)',
                    ],
                    [
                        'role' => 'user',
                        'content' => "parse the following resume content and extract the information as a JSON Object with the exact keys: 'summary', 'education', 'skills', 'experience', 'contactDetails'. Resume content is: ".$rawText.' return an empty string for any key that is not found.',
                    ],
                ],
                'temperature' => 1,
            ]);

            $result = $response->choices[0]->message->content;
            Log::debug('OpenAI Response'.$result);

            $parseResult = json_decode($result, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('Failed to parse OpenAI response: '.json_last_error_msg());
                throw new \Exception('Failed to parse OpenAI response');
            }
            // validate the keys in the parsed result
            $requiredKeys = ['contactDetails', 'education', 'summary', 'skills', 'experience'];
            foreach ($requiredKeys as $key) {
                if (! array_key_exists($key, $parseResult)) {
                    Log::error('Missing key in parsed result: '.$key);
                    throw new \Exception('Missing key in parsed result: '.$key);
                }
            }

            return [
                'contactDetails' => $this->stringifyField($parseResult['contactDetails'] ?? ''),
                'education' => $this->stringifyField($parseResult['education'] ?? ''),
                'summary' => $this->stringifyField($parseResult['summary'] ?? ''),
                'skills' => $this->stringifyField($parseResult['skills'] ?? ''),
                'experience' => $this->stringifyField($parseResult['experience'] ?? ''),
            ];
        } catch (\Exception $e) {
            Log::error('Error in extractResumeInfo: '.$e->getMessage());

            return [
                'contactDetails' => '',
                'education' => '',
                'summary' => '',
                'skills' => '',
                'experience' => '',

            ];
        }
    }

    public function analyzeResume($jobVacancy, $resumeData)
    {

        try {
            $jobDetails = json_encode([
                'job_title' => $jobVacancy->title,
                'job_description' => $jobVacancy->description,
                'job_location' => $jobVacancy->location,
                'job_type' => $jobVacancy->type,
                'job_salary' => $jobVacancy->salary,
            ]);
            $resumeDetails = json_encode($resumeData);

            $response = OpenAI::chat()->create([
                'model' => 'gpt-5.6-luna',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are an expert HR professional and job recruiter.
                             You will be given a job vacancy and a resume.
                              Your task is to analyze the resume against the job vacancy and provide a score from 0 to 100 based on how well the resume matches the job vacancy.
                               A score of 100 indicates a perfect match, while a score of 0 indicates no match at all.
                                Please provide only the score as an integer without any additional text or explanation.
                                Response should be in JSON format with the key "AiGeneratedScore", "AiGeneratedFeedback".
                                AiGeneratedFeedback should be detailed and specific to the job and the candidate\'s resume.',
                    ],
                    [
                        'role' => 'user',
                        'content' => 'Please Evaluate this job application. JobDetails: '.$jobDetails."\n\nResumeDetails: ".$resumeDetails,
                    ],
                ],
                'response_format' => [
                    'type' => 'json_object',
                ],
                'temperature' => 1,
            ]);
            $result = $response->choices[0]->message->content;
            Log::debug('Evaluation Response'.$result);
            $parseResult = json_decode($result, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('Failed to parse OpenAI response: '.json_last_error_msg());
                throw new \Exception('Failed to parse OpenAI response');
            }
            if (isset($parseResult['AiGeneratedScore']) && isset($parseResult['AiGeneratedFeedback'])) {
                return $parseResult;
            } else {
                throw new \Exception('Missing Required Keys in the parsed result: ');
            }
        } catch (\Exception $e) {
            Log::error('Error in analyzeResume: '.$e->getMessage());

            return [
                'AiGeneratedScore' => 0,
                'AiGeneratedFeedback' => 'Error in analyzing resume: '.$e->getMessage(),
            ];
        }
    }

    private function stringifyField(mixed $field): string
    {
        if (! is_array($field)) {
            return (string) $field;
        }

        $values = [];
        array_walk_recursive($field, function ($value) use (&$values) {
            $values[] = $value;
        });

        return implode(', ', $values);
    }

    private function extractTextFromPdf(string $fileUrl): string
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'resume');

        $filePath = parse_url($fileUrl, PHP_URL_PATH);
        if (! $filePath) {
            throw new \Exception('Invalid file URL');
        }
        $fileName = basename($filePath);

        $storagePath = 'resumes/'.$fileName;

        if (! Storage::disk('cloud')->exists($storagePath)) {
            throw new \Exception('File not found in storage');
        }

        $pdfContent = Storage::disk('cloud')->get($storagePath);
        if (! $pdfContent) {
            throw new \Exception('Failed to read the file');
        }
        file_put_contents($tempFile, $pdfContent);

        // check if the pdf to text installed
        $pdfToTextPath = ['/opt/homebrew/bin/pdftotext', '/usr/local/bin/pdftotext', '/usr/bin/pdftotext'];
        $pdfToTextAvailable = false;

        foreach ($pdfToTextPath as $path) {
            if (file_exists($path)) {
                $pdfToTextAvailable = true;
                break;
            }
        }

        if (! $pdfToTextAvailable) {
            throw new \Exception('pdftotext is not installed');
        }

        // Extracrt text from the PDF file using Spatie\PdftoText
        $instance = new Pdf;
        $text = $instance->setPdf($tempFile)->text();

        // clean up the temporary file
        unlink($tempFile);

        return $text; // Return the extracted text
    }
}
