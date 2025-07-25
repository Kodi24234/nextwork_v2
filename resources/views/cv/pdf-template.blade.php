<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->name }} - CV</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            line-height: 1.5;
            color: #333;
            background: white;
            font-size: 14px;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .cv-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 48px;
            background: white;
        }

        .cv-header {
            text-align: center;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 20px;
            margin-bottom: 24px;
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

        /* Fixed contact section to match preview */
        .cv-contact {
            text-align: center;
            font-size: 14px;
            color: #555;
        }

        .cv-contact span {
            display: inline-block;
            margin: 0 12px;
        }

        .cv-section {
            margin-bottom: 24px;
        }

        .cv-section-title {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1px solid #ecf0f1;
            padding-bottom: 8px;
        }

        .cv-item {
            margin-bottom: 16px;
            padding-left: 0;
        }


        .cv-item-header {
            display: block;
            margin-bottom: 4px;
            overflow: hidden;
        }

        .cv-item-title {
            font-size: 16px;
            font-weight: 600;
            color: #2c3e50;
            float: left;
            width: 70%;
        }

        .cv-item-date {
            font-size: 14px;
            color: #7f8c8d;
            font-weight: 400;
            float: right;
            width: 30%;
            text-align: right;
        }

        /* Clear floats */
        .cv-item-header::after {
            content: "";
            display: table;
            clear: both;
        }

        .cv-item-company {
            font-size: 14px;
            color: #555;
            margin-bottom: 8px;
            font-style: italic;
            clear: both;
        }

        .cv-item-description {
            font-size: 14px;
            color: #666;
            line-height: 1.5;
        }


        .cv-skills {
            line-height: 1.8;
        }

        .cv-skill {
            background-color: #ecf0f1;
            color: #2c3e50;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 500;
            margin-right: 8px;
            margin-bottom: 8px;
            display: inline-block;
        }

        .cv-summary {
            font-size: 14px;
            color: #555;
            line-height: 1.5;
            text-align: justify;
            word-wrap: break-word;
            hyphens: auto;
        }

        .no-data {
            color: #95a5a6;
            font-style: italic;
            font-size: 14px;
        }

        /* Print optimization */
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }

            .cv-container {
                padding: 20px;
            }
        }


        .cv-section {
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .cv-item {
            page-break-inside: avoid;
            break-inside: avoid;
        }


        .cv-section:last-child {
            margin-bottom: 0;
        }

        .cv-item:last-child {
            margin-bottom: 0;
        }

        .cv-section-title {
            page-break-after: avoid;
            break-after: avoid;
        }

        @page {
            margin: 20mm;
            size: A4;
        }
    </style>
</head>

<body>
    <div class="cv-container">
        <!-- Header -->
        <div class="cv-header">
            <h1 class="cv-name">{{ $user->name }}</h1>
            <p class="cv-title">{{ $user->profile->headline ?? 'Professional Title' }}</p>
            <div class="cv-contact">
                <span>Email: {{ $user->email }}</span>
                <span>Location: {{ $user->profile->location ?? 'City, Country' }}</span>
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
    </div>
</body>

</html>
