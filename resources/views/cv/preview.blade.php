@extends('layouts.nextwork')

@section('title', 'Preview CV')

@section('content')
    <style>
        .cv-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 48px;
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .cv-header {
            text-align: center;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 24px;
            margin-bottom: 32px;
        }

        .cv-name {
            font-size: 32px;
            font-weight: 300;
            color: #2c3e50;
            margin-bottom: 8px;
            letter-spacing: 1px;
        }

        .cv-title {
            font-size: 16px;
            color: #7f8c8d;
            margin-bottom: 16px;
            font-weight: 400;
        }

        .cv-contact {
            display: flex;
            justify-content: center;
            gap: 24px;
            font-size: 14px;
            color: #555;
        }

        .cv-contact span {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .cv-section {
            margin-bottom: 32px;
        }

        .cv-section-title {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1px solid #ecf0f1;
            padding-bottom: 8px;
        }

        .cv-item {
            margin-bottom: 20px;
            padding-left: 0;
        }

        .cv-item-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 4px;
        }

        .cv-item-title {
            font-size: 16px;
            font-weight: 600;
            color: #2c3e50;
        }

        .cv-item-date {
            font-size: 14px;
            color: #7f8c8d;
            font-weight: 400;
        }

        .cv-item-company {
            font-size: 14px;
            color: #555;
            margin-bottom: 8px;
            font-style: italic;
        }

        .cv-item-description {
            font-size: 14px;
            color: #666;
            line-height: 1.5;
        }

        .cv-skills {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .cv-skill {
            background-color: #ecf0f1;
            color: #2c3e50;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 500;
        }

        .cv-summary {
            font-size: 14px;
            color: #555;
            line-height: 1.6;
            text-align: justify;
        }

        .cv-download {
            text-align: center;
            margin-top: 40px;
            padding-top: 24px;
            border-top: 1px solid #ecf0f1;
        }

        .cv-download-btn {
            background-color: #2c3e50;
            color: white;
            padding: 12px 24px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .cv-download-btn:hover {
            background-color: #34495e;
            color: white;
            text-decoration: none;
        }

        .no-data {
            color: #95a5a6;
            font-style: italic;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .cv-container {
                margin: 20px;
                padding: 32px 24px;
            }

            .cv-contact {
                flex-direction: column;
                gap: 8px;
            }

            .cv-item-header {
                flex-direction: column;
                gap: 4px;
            }

            .cv-name {
                font-size: 28px;
            }
        }
    </style>

    <div class="cv-container">
        <!-- Header -->
        <div class="cv-header">
            <h1 class="cv-name">{{ $user->name }}</h1>
            <p class="cv-title">{{ $user->profile->headline ?? 'Professional Title' }}</p>
            <div class="cv-contact">
                <span>📧 {{ $user->email }}</span>
                <span>📍 {{ $user->profile->location ?? 'City, Country' }}</span>
            </div>
        </div>

        <!-- Summary Section -->
        @if ($user->profile->summary)
            <div class="cv-section">
                <h2 class="cv-section-title">Professional Summary</h2>
                <p class="cv-summary">{{ $user->profile->summary }}</p>
            </div>
        @endif

        <!-- Work Experience -->
        <div class="cv-section">
            <h2 class="cv-section-title">Work Experience</h2>
            @forelse ($user->workExperiences as $exp)
                <div class="cv-item">
                    <div class="cv-item-header">
                        <div class="cv-item-title">{{ $exp->job_title }}</div>
                        <div class="cv-item-date">
                            {{ \Carbon\Carbon::parse($exp->start_date)->format('M Y') }} -
                            {{ $exp->end_date ? \Carbon\Carbon::parse($exp->end_date)->format('M Y') : 'Present' }}
                        </div>
                    </div>
                    <div class="cv-item-company">{{ $exp->company_name }}</div>
                    @if ($exp->description)
                        <div class="cv-item-description">
                            {!! nl2br(e($exp->description)) !!}
                        </div>
                    @endif
                </div>
            @empty
                <p class="no-data">No work experience added yet.</p>
            @endforelse
        </div>

        <!-- Education -->
        <div class="cv-section">
            <h2 class="cv-section-title">Education</h2>
            @forelse ($user->education as $edu)
                <div class="cv-item">
                    <div class="cv-item-header">
                        <div class="cv-item-title">{{ $edu->degree }}</div>
                        <div class="cv-item-date">
                            {{ \Carbon\Carbon::parse($edu->start_date)->format('M Y') }} -
                            {{ $edu->end_date ? \Carbon\Carbon::parse($edu->end_date)->format('M Y') : 'Present' }}
                        </div>
                    </div>
                    <div class="cv-item-company">{{ $edu->institution_name }}</div>
                    @if ($edu->description)
                        <div class="cv-item-description">{{ $edu->description }}</div>
                    @endif
                </div>
            @empty
                <p class="no-data">No education history added yet.</p>
            @endforelse
        </div>

        <!-- Skills -->
        <div class="cv-section">
            <h2 class="cv-section-title">Skills</h2>
            @if ($user->skills->isNotEmpty())
                <div class="cv-skills">
                    @foreach ($user->skills as $skill)
                        <span class="cv-skill">{{ $skill->name }}</span>
                    @endforeach
                </div>
            @else
                <p class="no-data">No skills added yet.</p>
            @endif
        </div>

        <!-- Download Button -->
        <div class="cv-download">
            <a href="{{ route('cv.download') }}" class="cv-download-btn" target="_blank">
                Download PDF
            </a>
        </div>
    </div>
@endsection
