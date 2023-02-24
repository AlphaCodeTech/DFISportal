<div>
    @if (QS::userIsTeamSAT())
        <div class="card">
            <div class="p-2 bg-dark d-flex justify-content-between align-items-center">
                <h6 class="card-title font-weight-bold">Exam Comments</h6>
                <div class="">
                    <a onclick="toggle('collapseE{{ $exam_record->id }}')"
                        id="collapseE{{ $exam_record->id }}" data-toggle="collapse" class="btn h btn-header-link text-white "
                        data-target="#collapse{{ $exam_record->id }}" href="#collapse{{ $exam_record->id }}"
                        aria-expanded="false" aria-controls="collapse{{ $exam_record->id }}">

                    </a>
                </div>
            </div>

            <div class="card-body collapse" data-parent="#accordion" id="collapse{{ $exam_record->id }}">
                <form class="ajax-update" method="post" action="{{ route('marks.comment_update', $exam_record->id) }}">
                    @csrf @method('PUT')

                    @if (QS::userIsTeamSAT())
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label font-weight-semibold">Teacher's Comment</label>
                            <div class="col-lg-10">
                                <input name="t_comment" value="{{ $exam_record->t_comment }}" type="text"
                                    class="form-control" placeholder="Teacher's Comment">
                            </div>
                        </div>
                    @endif

                    @if (QS::userIsTeamSA())
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label font-weight-semibold">Head Teacher's Comment</label>
                            <div class="col-lg-10">
                                <input name="p_comment" value="{{ $exam_record->p_comment }}" type="text"
                                    class="form-control" placeholder="Head Teacher's Comment">
                            </div>
                        </div>
                    @endif

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Submit form <i
                                class="icon-paperplane ml-2"></i></button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
