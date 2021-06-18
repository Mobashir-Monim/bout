<?php

namespace App\Http\Requests\AnnounementRequests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\EnterprisePart;
use App\Models\Role;
use App\Models\Announcement;
use Carbon\Carbon;

class Update extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $announcement = Announcement::find($this->route('announcement'));

        return auth()->user()->id == $announcement->user_id || auth()->user()->hasRole('super-admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'content' => 'required',
            'semester' => 'required|in:Summer,Fall,Spring',
            'year' => 'required|integer|between:2020,' . (Carbon::now()->year + 1),
            'valid_till' => 'required|date',
            'keywords' => 'required|array|min:1',
            'announcement_target' => 'required|array|min:1',
            'announcement_target.*' => 'in:' . implode(',', $this->getEnterprisePartIDs()),
        ];
    }

    public function getEnterprisePartIDs()
    {
        $epids = auth()->user()->hasRole('announcement-author%');
        
        if (gettype($epids) == 'boolean' && auth()->user()->hasRole('super-admin'))
            $epids = [null];

        if (in_array(null, $epids)) {
            $epids[] = 'all';
            foreach (EnterprisePart::all() as $ep)
                $epids[] = $ep->id;
        }

        return array_unique($epids);
    }

    public function messages()
    {
        return [
            'title.requrired' => 'Announcement must have a title.',
            'content.required' => 'Announcement must have content body',
            'semester' => [
                'required' => 'Announcement semester is required',
                'in' => 'Valid semester is needed for Announcement'
            ],
            'year' => [
                'required' => 'Announcement year is required',
                'integer' => 'Valid year is needed for Announcement',
                'between' => 'Announcement cannot be older than the system or more than one year from now'
            ],
            'valid_till' => [
                'required' => 'Announcement validity is required',
                'integer' => 'Announcement validity must be of date type',
            ],
            'keywords' => [
                'required' => 'Announcement must have keywords',
                'min' => 'Minimum 1 keyword must be specified'
            ],
            'announcement_target' => [
                'required' => 'Announcement must have announcement target',
                'min' => 'Minimum 1 announcement target must be specified'
            ],
            'announcement_target.*' => [
                'min' => 'Announcement must have valid announcement target'
            ],
        ];
    }
}
