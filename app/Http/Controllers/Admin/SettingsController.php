<?php

namespace App\Http\Controllers\Admin;

// Framework
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

// Request
use App\Http\Requests\Admin\Settings\UpdateSettingsRequest;
use Illuminate\Support\Facades\Storage;
use Larapack\ConfigWriter\Facade as Config;

class SettingsController extends Controller
{

    /**
     * Display the PasswordBag Home Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('admin');
    }
    
    /**
     * Return all the settings
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function all(){
    
        $settings = [
            'app_logo_mini' => config('settings.app_logo_mini'),
            'app_logo'      => config('settings.app_logo'),
            'title'         => config('settings.title'),
            'footer_text'   => config('settings.footer_text'),
            'theme_color'   => config('settings.theme_color'),
        ];
        
        return response()->json($settings);

    }

    /**
     * @param UpdateSettingsRequest $request
     * @return @return \Illuminate\Http\Response
     */    
    public function update(UpdateSettingsRequest $request)
    {
        $settings = [];

        // Check if "App Logo Mini" exists and stores it
        if($request->hasFile('app_logo_mini') && $request->file('app_logo_mini')->isValid()){

            $path = $request->file('app_logo_mini')->store('img/settings', 'public');
            
            $path = $path;

            if(config('settings.app_logo_mini') != 'public/img/settings/logo.png') {

                Storage::disk('public')->delete(config('settings.app_logo_mini'));

            }

            Image::make('public/' . $path)->resize(null, 50,function ($constraint) {
                $constraint->aspectRatio();
            })->save();

            $settings['app_logo_mini'] = 'public/' . $path;

        }else{
            $settings['app_logo_mini'] = config('settings.app_logo_mini');
        }

        // Check if "App Logo" exists and stores it
        if($request->hasFile('app_logo') && $request->file('app_logo')->isValid()){

            $path = $request->file('app_logo')->store('img/settings', 'public');

            $path = $path;

            if(config('settings.app_logo') != 'public/img/settings/logo_lg.png') {

                Storage::disk('public')->delete(config('settings.app_logo_mini'));

            }

            Image::make('public/' . $path)->resize(null, 50,function ($constraint) {
                $constraint->aspectRatio();
            })->save();

            $settings['app_logo'] = 'public/' . $path;

        }else{
            $settings['app_logo'] = config('settings.app_logo'); 
        }

        $settings['theme_color'] = $request->input('theme_color');
        $settings['title'] = $request->input('title');
        $settings['footer_text'] = $request->input('footer_text');
        
        // Store Settings
        Config::write('settings', $settings);

        // Return fresh Settings
        return response()->json($settings);
    }
    
}
