<?php
namespace App\Http\Requests\Events\Medias;

use Illuminate\Foundation\Http\FormRequest;

class ReorderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Make sure it's coming from the author AND that the number of elements to reorder
        // matches the number of elements in the DB
        return (
            $this->route('event')->author_id === $this->user()->id &&
            $this->route('event')
                ->media()
                ->whereIn('id', $this->medias)
                ->count() ==
                count($this->medias)
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return ['medias' => 'required|array'];
    }
}
