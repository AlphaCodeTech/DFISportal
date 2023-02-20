<?php

namespace App\Http\Livewire\Backend\Pin;

use App\Helpers\QS;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Repositories\PinRepository;
use Illuminate\Support\Facades\App;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PinEnter extends Component
{
    public $student_id;
    public $pin_code;

    public function mount($id)
    {
        $this->student_id = $id;
        if (QS::userIsTeamSA()) {
            return redirect(route('dashboard'));
        }

        if ($this->checkPinVerified($this->student_id)) {
            return Session::has('marks_url') ? redirect(Session::get('marks_url')) : redirect()->route('dashboard');
        }
    }

    public function render(UserRepository $userRepository)
    {
        $student = $userRepository->findStudent($this->student_id);

        return view('livewire.backend.pin.pin-enter', compact('student'))->layout('backend.layouts.app');
    }
    protected $rules = [
        'pin_code' => 'required|max:18|regex:/[A-Za-z0-9]{5}-[A-Za-z0-9]{5}-[A-Za-z0-9]{6}/|exists:pins,code',
    ];

    public function updatedPinCode($pinCode)
    {
        $pin_code = $pinCode;
        $pin_code = Str::upper($pin_code ? $pin_code : '');

        if (strlen($pin_code) == 5) {
            $pin_code .= '-';
        }

        if (strlen($pin_code) == 11) {
            $pin_code .= '-';
        }

        $this->pin_code = $pin_code;
    }

    public function verify()
    {
        $this->validate();

        $pinRepository = App::make(PinRepository::class);
        $user = Auth::user();
        $code = $pinRepository->findValidCode($this->pin_code);

        if ($code->count() < 1) {
            $code = $pinRepository->getUserPin($this->pin_code, $user->id, $this->student_id);
        }

        if ($code->count() > 0 && $code->first()->times_used < 6) {
            $code = $code->first();
            $data['times_used'] = $code->times_used + 1;
            $data['user_id'] = $user->id;
            $data['student_id'] = $this->student_id;
            $data['used'] = true;

            $pinRepository->update($code->id, $data);

            Session::put('pin_verified', $this->student_id);

            return Session::has('marks_url') ? redirect(Session::get('marks_url')) : redirect()->route('backend.index');
        }

        toast(__('msg.pin_fail'), 'error');
        return redirect()->route('pins.enter', $this->student_id);
    }

    protected function checkPinVerified($student_id)
    {
        return Session::has('pin_verified') && Session::get('pin_verified') == $student_id;
    }
}
