<x-admin-layout>
    @push('extra-css')
        <style>
            .btn-header-link:after {
                content: "\f107";
                font-family: 'Font Awesome 5 Free';
                font-weight: 900;
                float: right;
            }
        </style>
    @endpush
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Marksheet</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">View Marksheet</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12" id="accordion">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title font-weight-bold">Student Marksheet for
                                    {{ $data['student_record']->name . ' (' . $data['class']->name . ' ' . $data['class']->sections->first()->name . ')' }}
                                </h4>

                            </div>
                        </div>
                        <!-- /.card-header -->
                        {{-- <div class="card-body" id="accordion"> --}}
                        @foreach ($data['exams'] as $exam)
                            @foreach ($data['exam_records']->where('exam_id', $exam->id) as $exam_record)
                            {{-- {{ $exam_record }} --}}
                                <div class="card">
                                    <div class="p-2 d-flex justify-content-between align-items-center bg-primary">
                                        <h6 class="font-weight-bold">
                                            {{ $exam->name . ' - ' . $exam->term->session->name }}</h6>
                                        <div class="">
                                            <a data-toggle="collapse" class="btn btn-header-link text-white"
                                                data-target="#collapseSk{{ $exam->id }}"
                                                href="#collapse{{ $exam->id }}" aria-expanded="true"
                                                aria-controls="collapseSk{{ $exam->id }}">
                                            </a>
                                        </div>
                                    </div>

                                    <div class="card-body collapse" data-parent="#accordion"
                                        id="collapseSk{{ $exam->id }}">
                                        {{-- Sheet Table --}}
                                        <livewire:backend.mark.show-sheets :student_record="$data['student_record']" :subjects="$data['subjects']"
                                            :marks="$data['marks']" :exam="$exam" :exam_record="$exam_record" :class="$data['class']" />

                                        {{-- Print Button --}}
                                        <div class="text-center mt-3">
                                            <a target="_blank"
                                                href="{{ route('marks.print', [$data['student_id'], $exam->id, $data['year']]) }}"
                                                class="btn btn-secondary btn-lg">Print Marksheet <i
                                                    class="icon-printer ml-2"></i></a>
                                        </div>

                                    </div>
                                </div>

                                {{--    EXAM COMMENTS   --}}
                                <livewire:backend.mark.show-comments :exam_record="$exam_record" :classLevel="$data['classLevel']->code" />

                                {{-- SKILL RATING --}}
                                <livewire:backend.mark.show-skills :exam_record="$exam_record" :skills="$data['skills']" />
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
</x-admin-layout>
