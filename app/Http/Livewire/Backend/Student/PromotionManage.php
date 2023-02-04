<?php

namespace App\Http\Livewire\Backend\Student;

use App\Helpers\QS;
use App\Models\Mark;
use Livewire\Component;
use App\Models\Promotion;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\App;
use App\Repositories\StudentRepository;

class PromotionManage extends Component
{
    use WithFileUploads;

    public $promotions;

    public function mount(StudentRepository $student)
    {
        $this->promotions = $student->getAllPromotions();
    }

    public function render()
    {
        return view('livewire.backend.student.promotion-manage')->layout('backend.layouts.app');
    }

    public function resetPromotion(Promotion $promotion)
    {
        $this->resetSingle($promotion->id);

        toast(__('msg.update_ok'), 'success');
        return redirect()->route('students.promotion_manage');
    }

    public function resetAll(StudentRepository $studentRepository)
    {
        $next_session = Qs::getNextSession();
        $where = ['current_session' => Qs::getCurrentSession(), 'next_session' => $next_session];
        $promotions = $studentRepository->getPromotions($where);

        if ($promotions->count()) {
            foreach ($promotions as $promotion) {
                $this->resetSingle($promotion->id);

                // Delete Marks if Already Inserted for New Session
                $this->deleteOldMarks($promotion->student_id, $next_session);
            }
        }
        
        toast(__('msg.update_ok'), 'success');
        return redirect()->route('students.promotion_manage');
    }

    protected function resetSingle($promotion_id)
    {
        $student = App::make(StudentRepository::class);

        $promotion = $student->findPromotion($promotion_id);

        $data['class_id'] = $promotion->current_class;
        $data['section_id'] = $promotion->current_section;
        $data['graduated'] = 0;
        $data['graduation_date'] = null;

        $student->update(['id' => $promotion->student_id], $data);

        return $student->deletePromotion($promotion_id);
    }

    protected function deleteOldMarks($student_id, $year)
    {
        Mark::where(['student_id' => $student_id, 'year' => $year])->delete();
    }
}
