<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\NoticeBoard;
use App\Models\IconLink;
use App\Models\QuickLink;
// use App\Providers\RouteServiceProvider;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;

class WebpageController extends Controller
{
    // use AuthenticatesUsers;
    // protected $redirectTo = RouteServiceProvider::HOME;
    function __construct()
    {
        // $this->middleware('guest')->except('logout');
        $this->middleware('permission:manage-webpage', ['only' => ['index']]);
    }
    public function index()
    {
        return view('webpage.index');
    }

    public function FrontIndex()
    {
        $banner = Banner::find(1);
        $notice_board = NoticeBoard::find(1);
        $iconlinks = IconLink::all();
        $quicklinks = QuickLink::all();

        return view('webpage', ['banner' => $banner, 'notice_board' => $notice_board, 'iconlinks' => $iconlinks, 'quicklinks' => $quicklinks]);
    }

    // *******************
    // Banner Image
    // *******************

    public function BannerCreate()
    {
        $banner = Banner::find(1);
        return view('webpage.banner.edit', ['banner' => $banner]);
    }
    public function BannerStore(Request $request)
    {
        $request->validate([
            'banner_image' => 'required',
        ]);

        $banner = Banner::findOrFail(1);

        if ($request->hasFile('banner_image')) {
            // Delete old image if exists
            $oldImage = public_path('/images/banners/' . $banner->banner_image);
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }

            $image = $request->file('banner_image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/banners');
            $image->move($destinationPath, $name);

            $banner->banner_image = $name;
        }

        $banner->save();

        return redirect('webpage')->with('success', 'Banner updated successfully.');
    }
   
    // *******************
    // Notice Board
    // *******************

    public function NoticeCreate()
    {
        $notice_board = NoticeBoard::find(1);
        return view('webpage.notice.edit', ['notice_board' => $notice_board]);
    }
    public function NoticeStore(Request $request)
    {
        $request->validate([
            'notice' => 'nullable',
        ]);

        $notice_board = NoticeBoard::findOrFail(1);
        $notice_board->notice = $request->input('notice');
        $notice_board->save();

        return redirect('webpage')->with('success', 'Notice updated successfully.');
    }

    // *******************
    // Link Icon
    // *******************

    Public function IconLink()
    {
        $iconlinks = IconLink::all();
        return view('webpage.linkicon.index',['iconlinks' => $iconlinks]);
    }
    Public function IconLinkCreate()
    {
        return view('webpage.linkicon.create');
    }
    public function IconLinkStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'link' => 'required|url',
            'banner_image' => 'required',
        ]);

        if ($request->hasFile('banner_image')) {
            $imageName = time().'.'.$request->banner_image->extension();  
            $request->banner_image->move(public_path('images/linkicons'), $imageName);
        }

        IconLink::create([
            'name' => $request->name,
            'link' => $request->link,
            'banner_image' => $imageName,
        ]);

        return redirect('webpage/iconlink/index')->with('success', 'IconLink created successfully.');
    }
    public function IconLinkEdit($id)
    {
        $iconlink = IconLink::findOrFail($id);
        return view('webpage.linkicon.edit', compact('iconlink'));
    }

    public function IconLinkUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'link' => 'required|url',
            'banner_image' => 'required',
        ]);

        $iconlink = IconLink::findOrFail($id);

        if ($request->hasFile('banner_image')) {
            if (file_exists(public_path('images/linkicons/' . $iconlink->banner_image))) {
                unlink(public_path('images/linkicons/' . $iconlink->banner_image));
            }

            $imageName = time().'.'.$request->banner_image->extension();  
            $request->banner_image->move(public_path('images/linkicons'), $imageName);
            $iconlink->banner_image = $imageName;
        }

        $iconlink->name = $request->name;
        $iconlink->link = $request->link;
        $iconlink->save();

        return redirect('webpage/iconlink/index')->with('success', 'IconLink updated successfully.');
    }
    public function IconLinkDestroy($id)
    {
        $iconlink = IconLink::findOrFail($id);
        if (file_exists(public_path('images/linkicons/' . $iconlink->banner_image))) {
            unlink(public_path('images/linkicons/' . $iconlink->banner_image));
        }

        $iconlink->delete();

        return redirect('webpage/iconlink/index')->with('success', 'IconLink deleted successfully.');
    }


      // *******************
    // Quick Icon
    // *******************

    Public function QuickLink()
    {
        $quicklinks = QuickLink::all();
        return view('webpage.quicklink.index',['quicklinks' => $quicklinks]);
    }
    Public function QuickLinkCreate()
    {
        return view('webpage.quicklink.create');
    }
    public function QuickLinkStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'link' => 'required|url',
        ]);

        QuickLink::create([
            'name' => $request->name,
            'link' => $request->link,
        ]);

        return redirect('webpage/quicklink/index')->with('success', 'QuickLink created successfully.');
    }

    public function QuickLinkEdit($id)
    {
        $quicklink = QuickLink::findOrFail($id);
        return view('webpage.quicklink.edit', compact('quicklink'));
    }

    public function QuickLinkUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'link' => 'required|url',
        ]);

        $quicklink = QuickLink::findOrFail($id);


        $quicklink->name = $request->name;
        $quicklink->link = $request->link;
        $quicklink->save();

        return redirect('webpage/quicklink/index')->with('success', 'QuickLink updated successfully.');
    }
    public function QuickLinkDestroy($id)
    {
        $quicklink = QuickLink::findOrFail($id);

        $quicklink->delete();

        return redirect('webpage/quicklink/index')->with('success', 'QuickLink deleted successfully.');
    }
}

