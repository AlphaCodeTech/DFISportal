
<section class="Admission-form">
    <div class="admission-text">
        <h1>DIVINE FAVOUR INTERNATIONAL SCHOOL</h1>
        <p>OPPOSITE HOLY TRINITY CATHOLIC CHURCH</p>
        <p>AWAKA, OWERRI-UMUOHIA ROAD </p>
        <p>OWERRI NORTH, IMO STATE</p>
        <p>REGISTERATION FORM (02)</p>
    </div>

    <div class="admit-form">
        <form method="POST" action="{{ route('student.store') }}" enctype="multipart/form-data" style="display: {{ request('enabled') ? 'block' : 'none' }}">
            @csrf
            <h2>SECTION B (CHILD'S DETAIL)</h2>
            <input name="surname" type="text" placeholder="First Name">
            <input name="middlename" type="text" placeholder="Second Name">
            <input name="lastname" type="text" placeholder=" Last Name">
            <input name="dob" type="date" placeholder="Date of Birth">
            <select name="blood_group" id="">
                <option value="Blood Group">Blood Group</option>
                <option value="A+">A RhD Positive (A+) </option>
                <option value="A-">A- RhD Negative (A-) </option>
                <option value="B+">B+ RhD Positive (B+) </option>
                <option value="B-">B- RhD Negative (B-) </option>
                <option value="O+">O+ RhD Positive (O+) </option>
                <option value="O-">O- RhD Negative (O-) </option>
                <option value="AB+">AB+ RhD Positive (AB+) </option>
                <option value="AB-">AB- RhD Negative (AB-) </option>
            </select>

            <select name="genotype" id="">
                <option value="Genotype">Genotype</option>
                <option value="AA">AA</option>
                <option value="AS">AS</option>
                <option value="AC">AC</option>
                <option value="SS">SS</option>
                <option value="SC">SC</option>
            </select>
            {{-- <input type="text" placeholder="Enter Admission Number"> --}}
            <input name="admission_date" type="date" placeholder="Enter Admission date">
            <input name="allergies" type="text" placeholder="Any Allergies?">
            <input name="disabilities" type="text" placeholder="Any Disability?">

            <select name="gender" id="">
                <option value="Gender">Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>

            <input name="prevSchool" type="text" placeholder="Name of previous school">
            <input name="reason" type="text" placeholder="Reason for leaving the previous school?">
            <input name="introducer" type="text" placeholder="Who Introduced You to the School">
            <input name="driver" type="text" placeholder="Who Picks Child From School">

            <h2>SUPPORTING DOCUMENT (A COPY OF)</h2>
            <label for="certificate">Child’s Birth Certificate</label>
            <input name="birth_certificate" type="file" id="cert"><br>
            <label for="Passport" id="pass">Child’s Passport</label>
            <input name="photo"  type="file" id="pass"><br>
            <label for="Passport">Child’s Immunization Card</label>
            <input name="immunization_card" type="file" id="pass"><br>


            <input type="submit" id="btn" value="Submit Details">

        </form>

        <form wire:submit.prevent='saveParent' style="display: {{ request('enabled') ? 'none' : 'block' }}">
            <h2>SECTION A: (PARENT/GUARDIAN)</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" wire:model='name' class="form-control" id="name" placeholder="Name">
                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="text" wire:model='residential_address' class="form-control"
                            id="residential_address" placeholder="Residential Address">
                        @error('residential_address')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="text" wire:model='nationality' class="form-control" id="nationality"
                            placeholder="Nationality">
                        @error('nationality')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="text" wire:model='lga' class="form-control" id="lga"
                            placeholder="Locat Govt. of origin">
                        @error('lga')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="text" wire:model='business_address' class="form-control"
                            id="business_address" placeholder="Office / Business Address">
                        @error('business_address')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="text" wire:model='relationship' class="form-control" id="relationship"
                            placeholder="Relationship with Child">
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
