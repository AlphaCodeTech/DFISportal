<section class="contact bg-white p-5 text-center text-sm-start">
    <div class="container">
        <h1 class="text-center">Fill your details below</h1>
        <form action="{{ route('fees.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 p-3">
                    <div class="mb-3">
                        <label for="admno" class="form-label">
                            Admission Number
                        </label>
                        <input wire:model.debounce.500ms='admno' type="text" style="height: 50px;"
                            class="form-control @error('admno') is-invalid @enderror">
                        @error('admno')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <input wire:model='studentID' type="hidden" name="student_id">

                    <div class="mb-3">
                        <label for="term" class="form-label">
                            Term
                        </label>
                        <input wire:model='term' name="term_id" type="text" class="form-control"
                            style="height: 50px;" readonly>
                        @error('term_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="level" class="form-label">
                            Level
                        </label>
                        <input wire:model='level' type="text" style="height: 50px;" class="form-control" readonly>
                        @error('level')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="Email" class="form-label">
                            Email
                        </label>
                        <input wire:model='email' name="email" type="text" style="height: 50px;"
                            class="form-control">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="amountPaid" class="form-label">
                            Amount
                        </label>
                        <select wire:model='amountPaid' class="form-control" name="Amount" id="Amount">
                            <option class="form-control">Please Select Amount</option>
                            @if (!is_null($fullFees))
                                <option class="form-control" value="{{ $fullFees }}">
                                    {{ 'Full payment - ' . $fullFees }}
                                </option>
                            @endif

                            @if (!is_null($partFees))
                                <option class="form-control" value="{{ $partFees }}">
                                    {{ 'Part payment - ' . $partFees }}
                                </option>
                            @endif

                        </select>
                        @error('amount_paid')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="class" class="form-label">
                            Class
                        </label>
                        <input wire:model='class' type="text" style="height: 50px;" class="form-control" readonly>
                        @error('class')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6 p-3">
                    <div class="mb-3">
                        <label for="Surname" class="form-label">
                            Surname
                        </label>
                        <input type="text" wire:model='surname' style="height: 50px;" class="form-control"
                            id="Surname">
                    </div>
                    <div class="mb-3">
                        <label for="Middle-name" class="form-label">
                            Middle Name
                        </label>
                        <input wire:model='middlename' type="text" style="height: 50px;" class="form-control"
                            id="Middle-name">
                    </div>
                    <div class="mb-3">
                        <label for="last-name" class="form-label">
                            Last Name
                        </label>
                        <input wire:model='lastname' type="text" style="height: 50px;" class="form-control"
                            id="last-name">
                    </div>
                    <div class="mb-3">
                        <label for="total-fees" class="form-label">
                            Total Fees
                        </label>
                        <input wire:model='fullFees' name="total_fees" type="text" style="height: 50px;"
                            class="form-control" id="total-fees">
                        @error('total_fees')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="amount_paid" class="form-label">
                            Amount Paid
                        </label>
                        <input wire:model='amountPaid' name="amount_paid" type="text" style="height: 50px;"
                            class="form-control">
                        @error('amount_paid')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="amount_unpaid" class="form-label">
                            Amount Unpaid
                        </label>
                        <input wire:model='amountUnPaid' name="amount_unpaid" type="text" style="height: 50px;"
                            class="form-control">
                    </div>
                </div>

                <div class="col">
                    <input class="form-control" style="height: 47px;" type="submit" id="btn"
                        value="Continue">
                </div>
            </div>
        </form>
    </div>
</section>
