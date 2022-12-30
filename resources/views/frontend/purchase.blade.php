@extends('frontend.layouts.app')

@section('frontend')
    
<section class="Admission-form">
    <div class="admission-text">
        <h1>DIVINE FAVOUR INTERNATIONAL SCHOOL</h1>
        <p>OPPOSITE HOLY TRINITY CATHOLIC CHURCH</p>
        <p>AWAKA, OWERRI-UMUOHIA ROAD </p>
        <p>OWERRI NORTH, IMO STATE</p>
        <p>REGISTERATION FORM (02)</p>
        <P>SECTION A (CHILD'S DETAIL)</P>
    </div>

    <div class="admit-form">
        <form action="">
             <input type="text" placeholder="First Name" required>
             <input type="text" placeholder="Second Name">
             <input type="text" placeholder=" Last Name" required>
             <input type="date" placeholder="Date of Birth" required>
             <select name="Blood group" id="" required>
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

             <select name="Genotype" id="" required>
                <option value="Genotype">Genotype</option>
                <option value="AA">AA</option>
                <option value="AS">AS</option>
                <option value="AC">AC</option>
                <option value="SS">SS</option>
                <option value="SC">SC</option>
             </select>
             <input type="text" placeholder="Enter Admission Number" required>
             <input type="date" placeholder="Enter Admission date" required>
             <input type="text" placeholder= "Any Allergies?" required>
             <input type="text" placeholder="Any Disability?" required>

             <select name="Gender" id="" required>
                <option value="Gender">Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
             </select>

             <input type="text" placeholder="Name of previous school and reason for leaving" required>
             <input type="text" placeholder="Any Other Information?" required>
             <h2>SECTION B: (PARENT/GUARDIAN)</h2>
             <input type="text" placeholder="Name" required>
             <input type="email" placeholder="Enter Your Email">
             <input type="text" placeholder="Residential Address" required>
             <input type="text" placeholder="Religion" required>
             <input type="text" placeholder="Nationality" required>
             <input type="text" placeholder="State Of Origin" required>
             <input type="text" placeholder="Local Govt. Of Origin" required>
             <input type="text" placeholder="Occupation" required>
             <input type="text" placeholder="Office/ Business Address" required>
             <input type="text" placeholder="Phone No:" required>
             <input type="text" placeholder="Relationship With Child" required>
             <input type="text" placeholder="Any Family History?"> <br>

                <h2>SUPPORTING DOCUMENT (A COPY OF)</h2>
                <label for="Passport"> Parents Valid National Identity Card</label>
                <input type="file" id="pass"><br>
                <label for="Passport">Child’s Birth Certificate</label>
                <input type="file" id="pass"><br>
                <label for="Passport" id="pass">Child’s Passport (2)</label>
                <input type="file" id="pass" multiple><br>
                <label for="Passport">Child’s Immunization Card</label>
                <input type="file" id="pass"><br>
                <input type="text" placeholder="Who Introduced You to the School" required>
                <input type="text" placeholder="Who Picks Child From School" required>
            
             <input type="submit" id="btn" value="Submit Details">
             
        </form>
        
    </div>
</section>


@endsection
