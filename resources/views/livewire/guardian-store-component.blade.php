<section class="contact bg-white p-5 text-center text-sm-start">
    <div class="container">

        <form id="guardian" method="POST" action="{{ route('guardian.store') }}" enctype="multipart/form-data"
            class="needs-validation" novalidate>
            @csrf
            <!-- fieldsets -->
            <fieldset>
                <div class="form-card">
                    <div class="row">
                        <div class="col-7">
                            <h2 class="fs-title">Parent / Guardian</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    Name
                                </label>
                                <input name="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    Email
                                </label>
                                <input name="email" type="text"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="religion" class="form-label">
                                    Religion
                                </label>
                                <select name="religion" class="form-select @error('religion') is-invalid @enderror"
                                    value="{{ old('religion') }}">
                                    <option value="">Select your Religion</option>
                                    @foreach (['Christainity', 'Islamic'] as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                                @error('religion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="Relationship" class="form-label">
                                    Relationship with Child
                                </label>
                                <select name="relationship"
                                    class="form-select @error('relationship') is-invalid @enderror">
                                    <option value="">Select your Relationship with Child</option>
                                    @foreach (['Father', 'Mother', 'Aunty', 'Uncle', 'Brother', 'Sister', 'Cousin', 'Niece', 'Nephew', 'Others'] as $item)
                                        <option value="{{ $item }}"
                                            {{ old('relationahip') == $item ? 'selected' : '' }}>{{ $item }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('relationship')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="nationality" class="form-label">
                                    Nationality
                                </label>
                                <select wire:model='nationality' name="nationality"
                                    class="form-select @error('nationality') is-invalid @enderror"
                                    value="{{ old('nationality') }}">
                                    <option value="">Select your Country</option>
                                    @foreach ($nationalities as $item)
                                        <option value="{{ $item }}"
                                            {{ old('nationality') == $item ? 'selected' : '' }}>{{ $item }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('nationality')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="state" class="form-label">
                                    State Of Origin
                                </label>
                                <select name="state" wire:model='state'
                                    class="form-select @error('state') is-invalid @enderror"
                                    value="{{ old('state') }}">
                                    @if (isset($states))
                                        @foreach ($states as $item)
                                            <option value="{{ $item['name'] }}" wire:key="{{ $loop->index }}"
                                                {{ old('state') == $item ? 'selected' : '' }}>
                                                {{ $item['name'] }}</option>
                                        @endforeach
                                    @else
                                        <option value="">Select a country first</option>
                                    @endif
                                </select>
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="lga" class="form-label">
                                    Local Government
                                </label>
                                <input name="lga" type="text"
                                    class="form-control @error('lga') is-invalid @enderror"
                                    value="{{ old('lga') }}">
                                @error('lga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">
                                    Phone <span class="text-danger">(In International format. eg. 234805543332)</span>
                                </label>
                                <input name="phone" type="text"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="occupation" class="form-label">
                                    Occupation
                                </label>
                                <input name="occupation" type="text"
                                    class="form-control @error('occupation') is-invalid @enderror"
                                    value="{{ old('occupation') }}">
                                @error('occupation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="business_address" class="form-label">
                                    Business/ Office Address
                                </label>
                                <textarea name="business_address" class="form-control @error('business_address') is-invalid @enderror">{{ old('business_address') }}</textarea>
                                @error('business_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="family_history" class="form-label">
                                    Any Family History?
                                </label>
                                <textarea name="family_history" class="form-control @error('family_history') is-invalid @enderror">{{ old('family_history') }}</textarea>
                                @error('family_history')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="residential_address" class="form-label">
                                    Residential Address
                                </label>
                                <textarea name="residential_address" class="form-control @error('residential_address') is-invalid @enderror">{{ old('residential_address') }}</textarea>
                                @error('residential_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="id_card" class="form-label">ID Card</label>
                                <input name="id_card" class="form-control @error('id_card') is-invalid @enderror"
                                    type="file">
                                @error('id_card')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn bg-primary text-white">Submit</button>
                </div>

            </fieldset>
        </form>
    </div>
    </div>
</section>
