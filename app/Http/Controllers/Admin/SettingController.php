<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Support\SiteContent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    /** Length caps per group, keyed by field. Also the write whitelist. */
    protected const RULES = [
        'hero' => [
            'badge' => 'max:80',
            'titleLine1' => 'max:60',
            'titleAccent' => 'max:60',
            'titleLine3' => 'max:60',
            'subtitle' => 'max:600',
        ],
        'video' => [
            'badge' => 'max:80',
            'headingPre' => 'max:80',
            'headingAccent' => 'max:80',
            'subtitle' => 'max:600',
            'caption' => 'max:80',
        ],
        'contact' => [
            'address' => 'max:250',
            'email' => 'max:190',
            'phone' => 'max:40',
            'intro' => 'max:600',
        ],
    ];

    public function edit(string $group): View
    {
        return view('admin.settings', [
            'group' => $group,
            'values' => Setting::group($group),
        ]);
    }

    public function update(Request $request, string $group): JsonResponse
    {
        $rules = collect(self::RULES[$group])
            ->mapWithKeys(fn ($rule, $field) => [$field => ['nullable', 'string', $rule]])
            ->all();

        if ($group === 'contact') {
            $rules['email'] = ['nullable', 'email:rfc', 'max:190'];
        }

        $data = $request->validate($rules);

        // Merge over the current group so a partial (autosave) write keeps the rest.
        Setting::putGroup($group, array_merge(Setting::group($group), $data));
        SiteContent::flush();

        return response()->json(['saved' => true]);
    }
}
