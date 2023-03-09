@extends('frontend.layouts.minor')

@section('frontend')
    <section class="contact bg-white p-5 text-sm-start">
        <div class="container">
            <h1 class="text-center">Purchase Admission Form</h1>
            <form action="{{ route('form.fee.store') }}" method="POST">
                @csrf
                @php
                    $setting = App::make(App\Settings\AdmissionSetting::class);
                @endphp

                <div class="row">
                    <input type="hidden" name="phone" value="{{ $guardian->phone }}">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                Name
                            </label>
                            <input name="name" value="{{ $guardian->name }}" type="text" style="height: 50px;"
                                class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="current_session" class="form-label">
                                Admission Session
                            </label>
                            <input name="current_session" value="{{ $setting->current_session }}" type="text"
                                style="height: 50px;" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <input name="buyer_id" type="hidden" value="{{ $guardian->id }}">

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                Email
                            </label>
                            <input name="email" value="{{ $guardian->email }}" type="text" style="height: 50px;"
                                class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">
                                Amount
                            </label>
                            <input name="amount" value="{{ $setting->form_fee }}" type="text" style="height: 50px;"
                                class="form-control" readonly>
                        </div>
                    </div>

                </div>
                <div class="col">
                    <input class="form-control" style="height: 47px;" type="submit" id="btn" value="Continue">
                </div>
            </form>

        </div>
        </div>
    </section>
@endsection
