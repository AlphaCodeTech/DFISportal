<section class="Admission-form">
    <div class="admission-text">
        <h1>SCHOOL FEES</h1>
    </div>
    <div class="admit-form container">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('pay.fees') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <input class="form-control" type="text"
                                    wire:keydown.debounce.1000ms='fetchDetails($event.target.value)'
                                    placeholder="Enter Admission Number">
                                @error('admno')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                @php
                                    $terms = App\Models\Term::all();
                                @endphp
                                <select class="form-control" name="term_id" id="term_id" style="width: 500px;">
                                    <option value="">Select Term</option>
                                    @foreach ($terms as $term)
                                        <option value="{{ $term->id }}">
                                            {{ $term->term_type->name . ' - ' . $term->session->name }}</option>
                                    @endforeach
                                </select>
                                @error('term_id')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <select name="amount" class="form-control"
                                    wire:change='amountPaid($event.target.value)' id="" style="width: 500px;">
                                    <option value="" selected>Please Select Amount</option>
                                    <option value='{{ $fullFees }}'>{{ $fullFees }}</option>
                                    <option value='{{ $partFees }}'>{{ $partFees }}</option>
                                </select>
                                @error('amount')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input class="form-control" placeholder="Email" type="email" name="email" value="{{ $email }}"
                                    readonly>
                                @error('email')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input class="form-control" type="hidden" name="student_id" value="{{ $studentID }}"
                                    readonly>
                                @error('student_id')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input class="form-control" type="hidden" name="phone" value="{{ $phone }}"
                                    readonly>
                                @error('phone')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input class="form-control" placeholder="Level" type="text" name="level_id" value="{{ $level }}"
                                    readonly>
                                @error('level_id')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="form-group">
                                <input class="form-control" name="class" type="text" placeholder="Child class"
                                    value="{{ $class }}" readonly>
                                @error('class')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input class="form-control" name="customer_name" type="hidden"
                                    value="{{ $name }}" readonly>
                            </div>


                        </div>

                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="Surname"
                                    value="{{ $surname }}" readonly>
                            </div>

                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="Middle Name"
                                    value="{{ $middlename }}" readonly>
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="Last Name"
                                    value="{{ $lastname }}" readonly>
                            </div>

                            <div class="form-group">
                                <input class="form-control" type="text" name="total_fees" placeholder="Total Fees"
                                    value="{{ $fullFees }}" readonly>
                                @error('total_fees')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input class="form-control" name="amount_paid" type="text" placeholder="Amount Paid"
                                    value="{{ $amountPaid }}" readonly>
                                @error('amount_paid')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input class="form-control" type="text" name="amount_unpaid"
                                    placeholder="Amount Unpaid" value="{{ $amountUnPaid }}" readonly>
                                @error('amount_unpaid')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>


                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">

                            <div class="form-group">
                                <input type="submit" id="btn" value="Submit Payment">
                            </div>


                        </div>
                    </div>
                </form>

            </div>
        </div>

    </div>
</section>

@push('front-js')
    {{-- js --> --}}
    <script src="{{ asset('frontend/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        $(function() {

            setTimeout(() => {
                $(".error").hide('slow');
            }, 5000);

        });
    </script>
@endpush
