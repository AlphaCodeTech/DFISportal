@extends('frontend.layouts.app')

@section('frontend')
    <section class="Admission-form">
        <div class="admission-text">
            <h1>SCHOOL FEES</h1>
        </div>
        <div class="admit-form">
            <form action="">
                <select name="Term" id="" required>
                    <option value="Term">Please Select Term</option>
                    <option value="First">First Term - 2023/2024</option>
                    <option value="Second">Second Term - 2023/2024</option>
                </select>

                <select name="Level" id="" required>
                    <option value="Level">Please Select Level</option>
                    <option value="Creche">Creche</option>
                    <option value="Nursery">Nursery</option>
                    <option value="Toddlers">Toddlers</option>
                    <option value="Basic">Basic</option>
                </select>
                <input type="email" placeholder="Enter Your Email">
                <select name="Amount" id="" required>
                    <option value="Amount">Please Select Amount</option>
                </select>
                <input type="text" placeholder="Enter Admission Number" required>
                <input type="text" placeholder="Class" disabled>
                <input type="text" placeholder="Surname" disabled>
                <input type="text" placeholder="Middle Name" disabled>
                <input type="text" placeholder="Last Name" disabled>
                <input type="text" placeholder="Total Fees" disabled>
                <input type="text" placeholder="Amount Paid" disabled>
                <input type="text" placeholder="Amount Unpaid" disabled>

                <input type="submit" id="btn" value="Submit Details">

            </form>

        </div>
    </section>
@endsection
