<div>
    <html>

    <head>
        <title>Student Marksheet - {{ $student_record->name }}</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/dist/css/print.css') }}" />
    </head>

    <body>
        <div class="container">
            <div id="print" xmlns:margin-top="http://www.w3.org/1999/xhtml">
                {{--    Logo N School Details --}}
                <table width="100%">
                    <tr>
                        <td><img src="{{ asset($appSettings->logo) }}" style="max-height : 100px;"></td>

                        <td style="text-align: center; ">
                            <strong><span
                                    style="color: #1b0c80; font-size: 25px;">{{ strtoupper($appSettings->name) }}</span></strong><br />
                            <strong><span
                                    style="color: #000; font-size: 15px;"><i>{{ ucwords($appSettings->address) }}</i></span></strong><br />
                            <strong><span style="color: #000; font-size: 15px;"> REPORT SHEET
                                    {{ '(' . strtoupper($class_level->name) . ')' }}
                                </span></strong>
                        </td>
                        <td style="width: 100px; height: 100px; float: left;">
                            <img src="{{ asset($student_record->photo) }}" alt="..." width="100" height="100">
                        </td>
                    </tr>
                </table>
                <br />

                {{-- Background Logo --}}
                <div style="position: relative;  text-align: center; ">
                    <img src="{{ asset($appSettings->logo) }}"
                        style="max-width: 500px; max-height:600px; margin-top: 60px; position:absolute ; opacity: 0.2; margin-left: auto;margin-right: auto; left: 0; right: 0;" />
                </div>

                {{-- <!-- SHEET BEGINS HERE--> --}}
                <livewire:backend.mark.show-sheet :subjects="$subjects" :marks="$marks" :exam="$exam"
                    :exam_record="$exam_record" />
                {{-- Key to Grading --}}
                {{-- @include('pages.support_team.marks.print.grading') --}}

                {{-- TRAITS - PSCHOMOTOR & AFFECTIVE --}}
                <livewire:backend.mark.show-skills />

                <div style="margin-top: 25px; clear: both;"></div>

                {{--    COMMENTS & SIGNATURE    --}}
                <livewire:backend.mark.show-comments />


            </div>
        </div>

        <script>
            window.print();
        </script>
    </body>

    </html>

</div>
