<?php

namespace App\Http\Requests;

use App\Services\GettingChannelIdByLinkService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreChannelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'link' => ['required', 'url'],
            'remote_identifier' => [
                'required',
                Rule::unique('channels')->where('user_id', auth()->id())
            ],
            'user_id' => ['required']
        ];
    }

    public function prepareForValidation()
    {
        $this->merge(['remote_identifier' => $this->link ? $this->getChannelIdFromLink($this->link) : null]);
        $this->merge(['user_id' => auth()->id()]);
    }

    private function getChannelIdFromLink(string $url): string
    {
        $parsed = parse_url(rtrim($url, '/'));
        if (isset($parsed['path']) && preg_match('/^\/channel\/(([^\/])+?)$/', $parsed['path'], $matches)) {
            return $matches[1];
        }
        return (new GettingChannelIdByLinkService)->execute($url);
    }

    public function messages()
    {
        return [
            'remote_identifier.unique' => 'Channel already exists'
        ];
    }
}
