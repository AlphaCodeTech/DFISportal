<div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="p-2 d-flex justify-content-between align-items-center bg-danger">
                    <h6 class="card-title font-weight-bold">AFFECTIVE TRAITS</h6>
                    <div class="">
                        <a data-toggle="collapse" class="btn btn-header-link text-white"
                            data-target="#collapseAf{{ $exam_record->id }}" href="#collapseAf{{ $exam_record->id }}"
                            aria-expanded="false" aria-controls="collapseAf{{ $exam_record->id }}">

                        </a>
                    </div>
                </div>

                <div class="card-body collapse" data-parent="#accordion" id="collapseAf{{ $exam_record->id }}">
                    <form class="ajax-update" method="post"
                        action="{{ route('marks.skills_update', ['AF', $exam_record->id]) }}">
                        @csrf @method('PUT')
                        @foreach ($skills->where('skill_type', 'AF') as $af)
                            <div class="form-group row">
                                <label for="af"
                                    class="col-lg-6 col-form-label font-weight-semibold">{{ $af->name }}</label>
                                <div class="col-lg-6">
                                    <select data-placeholder="Select" name="af[]" id="af"
                                        class="form-control select">
                                        <option value=""></option>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <option
                                                {{ $exam_record->af && explode(',', $exam_record->af)[$loop->index] == $i ? 'selected' : '' }}
                                                value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>

                                </div>
                            </div>
                        @endforeach

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Submit form <i
                                    class="icon-paperplane ml-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="p-2 d-flex justify-content-between align-items-center bg-success">
                    <h6 class="card-title font-weight-bold">PSYCHOMOTOR SKILLS</h6>
                    <div class="">
                        <a data-toggle="collapse" class="btn btn-header-link text-white"
                            data-target="#collapsePy{{ $exam_record->id }}" href="#collapsePy{{ $exam_record->id }}"
                            aria-expanded="false" aria-controls="collapsePy{{ $exam_record->id }}">

                        </a>
                    </div>
                </div>

                <div class="card-body collapse" data-parent="#accordion" id="collapsePy{{ $exam_record->id }}">
                    <form class="ajax-update" method="post"
                        action="{{ route('marks.skills_update', ['PS', $exam_record->id]) }}">
                        @csrf @method('PUT')
                        @foreach ($skills->where('skill_type', 'PS') as $ps)
                            <div class="form-group row">
                                <label for="ps"
                                    class="col-lg-6 col-form-label font-weight-semibold">{{ $ps->name }}</label>
                                <div class="col-lg-6">
                                    <select data-placeholder="Select" name="ps[]" id="ps"
                                        class="form-control select">
                                        <option value=""></option>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <option
                                                {{ $exam_record->ps && explode(',', $exam_record->ps)[$loop->index] == $i ? 'selected' : '' }}
                                                value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        @endforeach
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Submit form <i
                                    class="icon-paperplane ml-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
