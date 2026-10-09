<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SiteSettingController extends Controller
{
    public function edit(): View
    {
        $siteSetting = SiteSetting::actual();

        return view('admin.site-settings.edit', compact('siteSetting'));
    }

    public function update(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'logo_izquierdo' => ['nullable', 'image', 'max:2048'],
            'logo_derecho' => ['nullable', 'image', 'max:2048'],
            'quitar_logo_izquierdo' => ['nullable', 'boolean'],
            'quitar_logo_derecho' => ['nullable', 'boolean'],
        ]);

        $siteSetting = SiteSetting::actual();

        if ($request->boolean('quitar_logo_izquierdo')) {
            if ($siteSetting->logo_izquierdo_path) {
                Storage::disk('public')->delete($siteSetting->logo_izquierdo_path);
            }
            $siteSetting->logo_izquierdo_path = null;
        } elseif ($request->hasFile('logo_izquierdo')) {
            if ($siteSetting->logo_izquierdo_path) {
                Storage::disk('public')->delete($siteSetting->logo_izquierdo_path);
            }
            $siteSetting->logo_izquierdo_path = $request->file('logo_izquierdo')->store('logos', 'public');
        }

        if ($request->boolean('quitar_logo_derecho')) {
            if ($siteSetting->logo_derecho_path) {
                Storage::disk('public')->delete($siteSetting->logo_derecho_path);
            }
            $siteSetting->logo_derecho_path = null;
        } elseif ($request->hasFile('logo_derecho')) {
            if ($siteSetting->logo_derecho_path) {
                Storage::disk('public')->delete($siteSetting->logo_derecho_path);
            }
            $siteSetting->logo_derecho_path = $request->file('logo_derecho')->store('logos', 'public');
        }

        $siteSetting->save();

        return redirect()->route('admin.site-settings.edit')->with('status', 'Logos actualizados.');
    }
}
