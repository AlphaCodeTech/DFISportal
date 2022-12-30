<section class="Admission-form">
    <div class="admission-text">
        <h1>SCHOOL FEES</h1>
    </div>
    <div class="admit-form">
        <form action="{{ route('pay.fees') }}" method="POST">
            @csrf
            <input type="text" wire:keydown.debounce.1000ms='fetchDetails($event.target.value)' placeholder="Enter Your Phone Number">
            <select name="term_id" id="term_id">
                <option value="Term">Please Select Term</option>
                <option value="First">First Term - 2023/2024</option>
                <option value="Second">Second Term - 2023/2024</option>
            </select>

            <select name="level_id" id="">
                <option value="">Please Select Level</option>
                <option value="Creche">Creche</option>
                <option value="Nursery">Nursery</option>
                <option value="Toddlers">Toddlers</option>
                <option value="Basic">Basic</option>
            </select>
            <input type="email" name="email" placeholder="Enter Your Email">
            <select name="amount_paid" id="">
                <option value="Amount">Please Select Amount</option>
            </select>
            <input type="text" placeholder="Enter Admission Number">
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
