<x-admin-layout>
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
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title font-weight-bold">Student Marksheet for
                                    {{ $data['student_record']->name . ' (' . $data['class']->name . ' ' . $data['class']->sections->first()->name . ')' }}
                                </h4>

                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                @foreach ($data['exams'] as $exam)
                                    @foreach ($data['exam_records']->where('exam_id', $exam->id) as $exam_record)
                                        <div class="card" id="accordion">
                                            <div class="card-header header-elements-inline">
                                                <h6 class="font-weight-bold">
                                                    {{ $exam->name . ' - ' . $exam->term->session->name }}</h6>
                                                <div class="header-elements">
                                                    
                                                </div>
                                            </div>

                                            <div class="card-body" data-toggle="collapse" href="#collapseOne">
                                                {{-- Sheet Table --}}
                                                <livewire:backend.mark.show-sheet :subjects="$data['subjects']" :marks="$data['marks']"
                                                    :exam="$exam" :exam_record="$exam_record" />

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
                                        <livewire:backend.mark.show-comments />

                                        {{-- SKILL RATING --}}
                                        <livewire:backend.mark.show-skills />
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
</x-admin-layout>
