
<section class="Admission-form">
    <div class="admission-text">
        <h1>DIVINE FAVOUR INTERNATIONAL SCHOOL</h1>
        <p>OPPOSITE HOLY TRINITY CATHOLIC CHURCH</p>
        <p>AWAKA, OWERRI-UMUOHIA ROAD </p>
        <p>OWERRI NORTH, IMO STATE</p>
        <p>REGISTERATION FORM (02)</p>
    </div>

    <div class="admit-form container">
        <form method="POST" action="{{ route('admission.store') }}" enctype="multipart/form-data"
            style="display: {{ request('enabled') ? 'block' : 'none' }}">
            @csrf
            <h2>SECTION B (CHILD'S DETAIL)</h2>
            <div class="row">
                @php
                    $parent_id = App\Models\Parents::find(session()->get('id')) ? App\Models\Parents::find(session()->get('id'))->id : null;
                @endphp
                <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                <div class="col-md-12 col-lg-6">
                    <div class="form-group">
                        <input class="form-control" id="surname" name="surname" type="text"
                            placeholder="First Name" value="{{ old('surname') }}">
                        @error('surname')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input class="form-control" id="lastname" name="lastname" type="text"
                            placeholder="Last Name" value="{{ old('lastname') }}">
                        @error('lastname')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <select style="width: 500px;" name="blood_group" class="form-control" id="blood_group">
                            <option value="">Blood Group</option>
                            <option value="A+" {{ old('blood_group') == 'A+' ? 'selected' : '' }}>A RhD Positive (A+) </option>
                            <option value="A-" {{ old('blood_group') == 'A-' ? 'selected' : '' }}>A- RhD Negative (A-) </option>
                            <option value="B+" {{ old('blood_group') == 'B+' ? 'selected' : '' }}>B+ RhD Positive (B+) </option>
                            <option value="B-" {{ old('blood_group') == 'B-' ? 'selected' : '' }}>B- RhD Negative (B-) </option>
                            <option value="O+" {{ old('blood_group') == 'O+' ? 'selected' : '' }}>O+ RhD Positive (O+) </option>
                            <option value="O-" {{ old('blood_group') == 'O-' ? 'selected' : '' }}>O- RhD Negative (O-) </option>
                            <option value="AB+" {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>AB+ RhD Positive (AB+) </option>
                            <option value="AB-" {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>AB- RhD Negative (AB-) </option>
                        </select>
                        @error('blood_group')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input class="form-control" id="allergies" name="allergies" type="text"
                            placeholder="Any allergies?" value="{{ old('allergies') }}">
                        @error('allergies')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <select style="width: 500px;" name="gender" class="form-control" id="gender">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('gender')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input class="form-control" id="reason" name="reason" type="text"
                            placeholder="Reason for leaving your formal school" value="{{ old('reason') }}">
                        @error('reason')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input class="form-control" name="introducer" type="text"
                            placeholder="Who Introduced You to the School" value="{{ old('introducer') }}">

                        @error('introducer')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <div class="col-md-12 col-lg-6">
                    <div class="form-group">
                        <input class="form-control" id="middlename" name="middlename" type="text"
                            placeholder="Second Name" value="{{ old('middlename') }}">
                        @error('middlename')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input class="form-control" id="dob" name="dob" type="date"
                            placeholder="Date of birth" value="{{ old('dob') }}">
                        @error('dob')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <select name="genotype" class="form-control" id="genotype" style="width: 500px;">
                            <option value="">Select Genotype</option>
                            <option value="AA" {{ old('genotype') == 'AA' ? 'selected' : '' }}>AA</option>
                            <option value="AS" {{ old('genotype') == 'AS' ? 'selected' : '' }}>AS</option>
                            <option value="AC" {{ old('genotype') == 'AC' ? 'selected' : '' }}>AC</option>
                            <option value="SS" {{ old('genotype') == 'SS' ? 'selected' : '' }}>SS</option>
                            <option value="SC" {{ old('genotype') == 'SC' ? 'selected' : '' }}>SC</option>
                        </select>
                        @error('genotype')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input class="form-control" id="disabilities" name="disabilities" type="text"
                            placeholder="Any disabilities?" value="{{ old('disabilities') }}">
                        @error('disabilities')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input class="form-control" id="prevSchool" name="prevSchool" type="text"
                            placeholder="Name of previous school?" value="{{ old('prevSchool') }}">
                        @error('prevSchool')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input class="form-control" name="driver" type="text"
                            placeholder="Who Picks Child From School" value="{{ old('driver') }}">
                        @error('driver')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        @php
                            $classes = App\Models\Clazz::all();
                        @endphp
                        <select name="class_id" class="form-control" id="genotype" style="width: 500px;">
                            <option value="">Select Class</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                            @endforeach

                        </select>
                        @error('class_id')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>


            <h2>SUPPORTING DOCUMENT (A COPY OF)</h2>
            <div class="row">
                <div class="col-lg-4">
                    <label for="birth_certificate" id="cert">Child’s Birth Certificate</label>
                </div>
                <div class="col-lg-8">
                    <div class="form-group">
                        <input class="form-control-file" name="birth_certificate" type="file" id="pass">

                    </div>
                    @error('birth_certificate')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <label for="Passport" id="pass">Child’s Passport</label>
                </div>
                <div class="col-lg-8">
                    <div class="form-group">
                        <input class="form-control-file" name="photo" type="file" id="pass">

                    </div>
                    @error('photo')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <label for="Passport">Child’s Immunization Card</label>
                </div>
                <div class="col-lg-8">
                    <div class="form-group">
                        <input class="form-control-file" name="immunization_card" type="file" id="pass">
                    </div>
                    @error('immunization_card')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <input type="submit" id="btn" value="Submit Details">

        </form>

        <form wire:submit.prevent='saveParent' style="display: {{ request('enabled') ? 'none' : 'block' }}">
            <h2>SECTION A: (PARENT/GUARDIAN)</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" wire:model='name' class="form-control" id="name"
                            placeholder="Name" value="{{ old('name') }}">
                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="text" wire:model='residential_address' class="form-control"
                            id="residential_address" placeholder="Residential Address" value="{{ old('residential_address') }}">
                        @error('residential_address')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="text" wire:model='nationality' class="form-control" id="nationality"
                            placeholder="Nationality" value="{{ old('nationality') }}">
                        @error('nationality')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="text" wire:model='lga' class="form-control" id="lga"
                            placeholder="Locat Govt. of origin" value="{{ old('lga') }}">
                        @error('lga')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="text" wire:model='business_address' class="form-control"
                            id="business_address" placeholder="Office / Business Address" value="{{ old('business_address') }}">
                        @error('business_address')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="text" wire:model='relationship' class="form-control" id="relationship"
                            placeholder="Relationship with Child" value="{{ old('relationship') }}">
                        @error('relationship')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" wire:model='email' class="form-control" id="email"
                            placeholder="Email">
                        @error('email')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="text" wire:model='religion' class="form-control" id="religion"
                            placeholder="Religion">
                        @error('religion')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="text" wire:model='state' class="form-control" id="state"
                            placeholder="State of Origin">
                        @error('state')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="text" wire:model='occupation' class="form-control" id="occupation"
                            placeholder="Occupation">
                        @error('occupation')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="text" wire:model='phone' class="form-control" id="phone"
                            placeholder="Phone Number">
                        @error('phone')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="text" wire:model='family_history' class="form-control" id="family_history"
                            placeholder="Any Family History?">
                        @error('family_history')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <h2>SUPPORTING DOCUMENT (A COPY OF)</h2>
                    <div class="row">
                        <div class="col-md-4">
                            <h4 for="Passport"> Parents Valid National Identity Card</h4>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <input wire:model='id_card' type="file" class="form-control-file" id="id_card">

                            </div>
                            @error('id_card')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>
            <input type="submit" id="btn" value="Submit Details">

        </form>
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
