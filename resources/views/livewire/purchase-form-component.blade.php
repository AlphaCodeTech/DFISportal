<section class="contact bg-white p-5 text-center text-sm-start">
    <div class="container">
        <form id="msform" method="POST" action="{{ route('admission.store') }}" enctype="multipart/form-data">
            @csrf
            <!-- progressbar -->
            <ul id="progressbar" style="display: flex; justify-content: space-around;">
                <li id="personal"><strong>Child</strong></li>
                <li id="payment"><strong>Documents</strong></li>
            </ul>
            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                    aria-valuemin="0" aria-valuemax="100"></div>
            </div> <br> <!-- fieldsets -->

            <fieldset>
                <div class="form-card">
                    <div class="row">
                        <div class="col-7">
                            <h2 class="fs-title">Section A (Child's Detail)</h2>
                        </div>
                        <div class="col-5">
                            <h2 class="steps">Step 1 - 2</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" name="guardian_id" value="{{ $guardian }}">
                            <input type="hidden" name="phone" value="{{ $phone }}">
                            <div class="mb-3">
                                <label for="surname" class="form-label">
                                    Surname
                                </label>
                                <input class="form-control @error('surname') is-invalid @enderror" name="surname"
                                    type="text" placeholder="Surname" value="{{ old('surname') }}">
                                @error('surname')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="second-name" class="form-label">
                                    Middlename
                                </label>
                                <input class="form-control @error('middlename') is-invalid @enderror" name="middlename"
                                    type="text" placeholder="Middle Name" value="{{ old('middlename') }}">
                                @error('middlename')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="last-name" class="form-label">
                                    Last Name
                                </label>
                                <input class="form-control @error('lastname') is-invalid @enderror" name="lastname"
                                    type="text" placeholder="Last Name" value="{{ old('lastname') }}">
                                @error('lastname')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="dob" class="form-label">
                                    Date of Birth
                                </label>
                                <input class="form-control @error('dob') is-invalid @enderror" name="dob"
                                    type="date" placeholder="Date of birth" value="{{ old('dob') }}">
                                @error('dob')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <select name="class_id" class="form-select @error('class_id') is-invalid @enderror">
                                    <option value="">Select Class</option>
                                    @foreach (App\Models\Clazz::all() as $class)
                                        <option value="{{ $class->id }}"
                                            {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }}</option>
                                    @endforeach
                                </select>
                                @error('class_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <select name="genotype" class="form-select @error('genotype') is-invalid @enderror">
                                    <option value="">Select Genotype</option>
                                    @foreach (['AA', 'AS', 'AC', 'SS', 'SC'] as $item)
                                        <option value="{{ $item }}"
                                            {{ old('genotype') == $item ? 'selected' : '' }}>
                                            {{ $item }}</option>
                                    @endforeach
                                </select>
                                @error('genotype')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <select name="blood_group"
                                    class="form-select @error('blood_group') is-invalid @enderror">
                                    <option value="">Select Blood Group</option>
                                    @foreach (['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $item)
                                        <option value="{{ $item }}"
                                            {{ old('blood_group') == $item ? 'selected' : '' }}>
                                            {{ $item }}</option>
                                    @endforeach
                                </select>
                                @error('blood_group')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                                    <option value="">Select Gender</option>
                                    @foreach (['male', 'female'] as $item)
                                        <option value="{{ $item }}"
                                            {{ old('gender') == $item ? 'selected' : '' }}>
                                            {{ Str::ucfirst($item) }}</option>
                                    @endforeach
                                </select>
                                @error('gender')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="prevSchool" class="form-label">
                                    Name of Previous Shool
                                </label>
                                <input class="form-control @error('prevSchool') is-invalid @enderror" name="prevSchool"
                                    type="text" placeholder="Name of previous school?"
                                    value="{{ old('prevSchool') }}">
                                @error('prevSchool')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="introducer" class="form-label">
                                    Who Introduce you to the school
                                </label>
                                <input class="form-control @error('introducer') is-invalid @enderror" name="introducer"
                                    type="text" placeholder="Who Introduced You to the School"
                                    value="{{ old('introducer') }}">

                                @error('introducer')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="driver" class="form-label">
                                    Who picks Child From School
                                </label>
                                <input class="form-control @error('driver') is-invalid @enderror" name="driver"
                                    type="text" placeholder="Who Picks Child From School"
                                    value="{{ old('driver') }}">
                                @error('driver')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="allergies" class="form-label">
                                    Any Allergy?
                                </label>
                                <textarea class="form-control @error('allergies') is-invalid @enderror" name="allergies" placeholder="Any allergies?">{{ old('allergies') }}</textarea>
                                @error('allergies')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="disabilities" class="form-label">
                                    Any Disability?
                                </label>
                                <textarea class="form-control @error('disabilities') is-invalid @enderror" name="disabilities" placeholder="Any disabilities?">{{ old('disabilities') }}</textarea>
                                @error('disabilities')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="reason" class="form-label">
                                    Any Other Information?
                                </label>
                                <textarea class="form-control @error('reason') is-invalid @enderror" name="reason" placeholder="Reason for leaving your formal school">{{ old('reason') }}</textarea>
                                @error('reason')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>
                <input type="button" name="next" class="next action-button" value="Next" />
            </fieldset>

            <fieldset>
                <div class="form-card">
                    <div class="row">
                        <div class="col-7">
                            <h2 class="fs-title">Supporting Document</h2>
                        </div>
                        <div class="col-5">
                            <h2 class="steps">Step 2 - 2</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="photo" class="form-label">Photo</label>
                                <input name="photo" class="form-control @error('photo') is-invalid @enderror"
                                    type="file">
                                @error('photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="birth_certificate" class="form-label">Birth Certificate</label>
                                <input name="birth_certificate"
                                    class="form-control @error('birth_certificate') is-invalid @enderror"
                                    type="file">
                                @error('birth_certificate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="immunization_card" class="form-label">Immunization Card</label>
                                <input name="immunization_card"
                                    class="form-control @error('immunization_card') is-invalid @enderror"
                                    type="file">
                                @error('immunization_card')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn bg-success text-white">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
            </fieldset>
        </form>
    </div>
    </div>
</section>
