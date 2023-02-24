<html>

<head>
    <title>Tabulation Sheet - {{ $class->name . ' ' . $section->name . ' - ' . $exam->name . ' (' . $year . ')' }}
    </title>
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/dist/css/print_tabulation.css') }}" />
</head>

<body>
    <div class="container">
        <div id="print" xmlns:margin-top="http://www.w3.org/1999/xhtml">
            {{--    Logo N School Details --}}
            <table width="100%">
                <tr>
                    {{-- <td><img src="{{ $student['logo'] }}" style="max-height : 100px;"></td> --}}

                    <td>
                        <strong><span
                                style="color: #1b0c80; font-size: 25px;">{{ strtoupper(QS::getAppSetting('name')) }}</span></strong><br />
                        {{-- <strong><span style="color: #1b0c80; font-size: 20px;">MINNA, NIGER STATE</span></strong><br/> --}}
                        <strong><span
                                style="color: #000; font-size: 15px;"><i>{{ ucwords($appSettings->address) }}</i></span></strong><br />
                        <strong><span style="color: #000; font-size: 15px;"> TABULATION SHEET FOR
                                {{ strtoupper($class->name . ' ' . $section->name . ' - ' . $exam->name . ' (' . $year . ')') }}
                            </span></strong>
                    </td>
                </tr>
            </table>
            <br />

            {{-- Background Logo --}}
            <div style="position: relative;  text-align: center; ">
                <img src="{{ asset($appSettings->logo) }}"
                    style="max-width: 500px; max-height:600px; margin-top: 60px; position:absolute ; opacity: 0.2; margin-left: auto;margin-right: auto; left: 0; right: 0;" />
            </div>

            {{-- Tabulation Begins --}}
            <table style="width:100%; border-collapse:collapse; border: 1px solid #000; margin: 10px auto;"
                border="1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NAMES OF STUDENTS IN CLASS</th>
                        @foreach ($subjects as $subject)
                            <th rowspan="2">{{ strtoupper($subject->name) }}</th>
                        @endforeach

                        <th style="color: darkred">Total</th>
                        <th style="color: darkblue">Average</th>
                        <th style="color: darkgreen">Position</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td style="text-align: left">
                                {{ $student->surname . ' ' . $student->middlename . ' ' . $student->lastname }}</td>
                            @foreach ($subjects as $subject)
                                <td>{{ $marks->where('student_id', $student->id)->where('subject_id', $subject->id)->first()->$tex ?? '-' }}
                                </td>
                            @endforeach

                            <td style="color: darkred">
                                {{ $exam_record->where('student_id', $student->id)->first()->total ?? '-' }}</td>
                            <td style="color: darkblue">
                                {{ $exam_record->where('student_id', $student->id)->first()->average ?? '-' }}</td>
                            <td style="color: darkgreen">{!! Mk::getSuffix($exam_record->where('student_id', $student->id)->first()?->position) ?? '-' !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        window.print();
    </script>
</body>

</html>
