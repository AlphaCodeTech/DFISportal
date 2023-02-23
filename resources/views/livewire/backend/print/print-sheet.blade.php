<div>
    {{-- <!--NAME , CLASS AND OTHER INFO --> --}}
    <table style="width:100%; border-collapse:collapse; ">
        <tbody>
            <tr>
                <td><strong>NAME:</strong>
                    {{ Str::upper($student_record->surname . ' ' . $student_record->firstname . ' ' . $student_record->middlename) }}
                </td>
                <td><strong>ADM NO:</strong> {{ $student_record->admno }}</td>
                <td><strong>HOUSE:</strong> {{ Str::upper($student_record->house ?? 'NULL') }}</td>
                <td><strong>CLASS:</strong> {{ Str::upper($class->name) }}</td>
            </tr>
            <tr>
                <td><strong>REPORT SHEET FOR</strong> {!! Str::upper(Mk::getSuffix($exam->term->id)) !!} TERM </td>
                <td><strong>ACADEMIC YEAR:</strong> {{ $exam->term->session->name }}</td>
                <td><strong>AGE:</strong>
                    {{ $student_record->dob ? Carbon\Carbon::parse($student_record->dob)->age : '-' }}
                </td>
            </tr>

        </tbody>
    </table>


    {{-- Exam Table --}}
    <table style="width:100%; border-collapse:collapse; border: 1px solid #000; margin: 10px auto;" border="1">
        <thead>
            <tr>
                <th rowspan="2">SUBJECTS</th>
                <th colspan="3">CONTINUOUS ASSESSMENT</th>
                <th rowspan="2">EXAM<br>({{ $appSettings->exam }})</th>
                <th rowspan="2">FINAL MARKS <br> (100%)</th>
                <th rowspan="2">GRADE</th>
                <th rowspan="2">SUBJECT <br> POSITION</th>


                {{--  @if ($exam->term == 3) --}}{{-- 3rd Term --}}{{--
        <th rowspan="2">FINAL MARKS <br>(100%) 3<sup>RD</sup> TERM</th>
        <th rowspan="2">1<sup>ST</sup> <br> TERM</th>
        <th rowspan="2">2<sup>ND</sup> <br> TERM</th>
        <th rowspan="2">CUM (300%) <br> 1<sup>ST</sup> + 2<sup>ND</sup> + 3<sup>RD</sup></th>
        <th rowspan="2">CUM AVE</th>
        <th rowspan="2">GRADE</th>
        @endif --}}

                <th rowspan="2">REMARKS</th>
            </tr>
            <tr>
                <th>1st CA({{ $appSettings->first_CA }})</th>
                <th>2nd CA({{ $appSettings->second_CA }})</th>
                <th>TOTAL({{ $appSettings->first_CA + $appSettings->second_CA }})</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subjects as $subject)
                <tr>
                    <td style="font-weight: bold; text-align: left;">{{ $subject->name }}</td>
                    @foreach ($marks->where('subject_id', $subject->id)->where('exam_id', $exam->id)->last() as $mark)
                        <td>{{ $mark->t1 ?: '-' }}</td>
                        <td>{{ $mark->t2 ?: '-' }}</td>
                        <td>{{ $mark->total_CA ?: '-' }}</td>
                        <td>{{ $mark->exam ?: '-' }}</td>

                        <td>{{ $mark->$tex ?: '-' }}</td>
                        <td>{{ $mark->grade ? $mark->grade->name : '-' }}</td>
                        <td>{!! $mark->grade ? Mk::getSuffix($mark->sub_pos) : '-' !!}</td>
                        <td>{{ $mark->grade ? $mark->grade->remark : '-' }}</td>

                        {{-- @if ($exam->term == 3)
                    <td>{{ $mark->tex3 ?: '-' }}</td>
                    <td>{{ Mk::getSubTotalTerm($student_id, $subject->id, 1, $mark->my_class_id, $year) }}</td>
                    <td>{{ Mk::getSubTotalTerm($student_id, $subject->id, 2, $mark->my_class_id, $year) }}</td>
                    <td>{{ $mark->cum ?: '-' }}</td>
                    <td>{{ $mark->cum_ave ?: '-' }}</td>
                    <td>{{ $mark->grade ? $mark->grade->name : '-' }}</td>
                    <td>{{ $mark->grade ? $mark->grade->remark : '-' }}</td>
                @endif --}}
                    @endforeach
                </tr>
            @endforeach
            <tr>
                <td colspan="3"><strong>TOTAL SCORES OBTAINED: </strong> {{ $exam_record->total }}</td>
                <td colspan="3"><strong>FINAL AVERAGE: </strong> {{ $exam_record->average }}</td>
                <td colspan="3"><strong>CLASS AVERAGE: </strong> {{ $exam_record->class_average }}</td>
            </tr>
        </tbody>
    </table>

</div>
