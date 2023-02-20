<div class="collapse show" id="collapseOne" data-parent="#accordion" wire:ignore.self>
    <table class="table table-bordered table-responsive text-center">
        <thead>
            <tr>
                <th rowspan="2">S/N</th>
                <th rowspan="2">SUBJECTS</th>
                <th rowspan="2">1st CA<br>(10)</th>
                <th rowspan="2">2nd CA<br>(30)</th>
                <th rowspan="2">EXAMS<br>(60)</th>
                <th rowspan="2">TOTAL<br>(100)</th>

                {{-- @if ($exam->term == 3) --}}{{-- 3rd Term --}}{{--
            <th rowspan="2">TOTAL <br>(100%) 3<sup>RD</sup> TERM</th>
            <th rowspan="2">1<sup>ST</sup> <br> TERM</th>
            <th rowspan="2">2<sup>ND</sup> <br> TERM</th>
            <th rowspan="2">CUM (300%) <br> 1<sup>ST</sup> + 2<sup>ND</sup> + 3<sup>RD</sup></th>
            <th rowspan="2">CUM AVE</th>
            @endif --}}

                <th rowspan="2">GRADE</th>
                <th rowspan="2">SUBJECT <br> POSITION</th>
                <th rowspan="2">REMARKS</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($subjects as $subject)
                {{-- {{ dd($subject) }} --}}
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $subject->name }}</td>
                    @foreach ($marks->where('subject_id', $subject->id)->where('exam_id', $exam->id) as $mark)
                        <td>{{ $mark->t1 ?: '-' }}</td>
                        <td>{{ $mark->t2 ?: '-' }}</td>
                        <td>{{ $mark->exam ?: '-' }}</td>
                        <td>
                            @if ($exam->term->id === 1)
                                {{ $mark->tex1 }}
                            @elseif ($exam->term->id === 2)
                                {{ $mark->tex2 }}
                            @elseif ($exam->term->id === 3)
                                {{ $mark->tex3 }}
                            @else
                                {{ '-' }}
                            @endif
                        </td>

                        {{-- 3rd Term --}}
                        {{-- @if ($exam->term == 3)
                         <td>{{ $mark->tex3 ?: '-' }}</td>
                         <td>{{ Mk::getSubTotalTerm($student_id, $subject->id, 1, $mark->my_class_id, $year) }}</td>
                         <td>{{ Mk::getSubTotalTerm($student_id, $subject->id, 2, $mark->my_class_id, $year) }}</td>
                         <td>{{ $mark->cum ?: '-' }}</td>
                         <td>{{ $mark->cum_ave ?: '-' }}</td>
                     @endif --}}

                        {{-- Grade, Subject Position & Remarks --}}
                        <td>{{ $mark->grade ? $mark->grade->name : '-' }}</td>
                        <td>{!! $mark->grade ? Mk::getSuffix($mark->sub_pos) : '-' !!}</td>
                        <td>{{ $mark->grade ? $mark->grade->remark : '-' }}</td>
                    @endforeach
                </tr>
            @endforeach
            <tr>
                <td colspan="4"><strong>TOTAL SCORES OBTAINED: </strong> {{ $exam_record->total }}</td>
                <td colspan="3"><strong>FINAL AVERAGE: </strong> {{ $exam_record->average }}</td>
                <td colspan="2"><strong>CLASS AVERAGE: </strong> {{ $exam_record->class_average }}</td>
            </tr>
        </tbody>
    </table>

</div>
