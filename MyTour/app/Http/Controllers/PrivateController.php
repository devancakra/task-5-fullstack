<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Articles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PrivateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function profile()
    {
        return view('profile');
    }

    public function create_article(Request $reqdata)
    {
        if ($reqdata->hasFile('image')) {
            Articles::create([
                'user_id' => Auth::user()->id,
                'category_id' => $reqdata->category_id,
                'title' => $reqdata->title,
                'image' => $reqdata->file('image')->move('img\media', $reqdata->file('image')->getClientOriginalName()),
                'content' => $reqdata->content
            ]);
        } else {
            Articles::create([
                'user_id' => Auth::user()->id,
                'category_id' => $reqdata->category_id,
                'title' => $reqdata->title,
                'image' => "none",
                'content' => $reqdata->content
            ]);
        }
        $msg = " Anda berhasil menambahkan artikel!!";
        return redirect()->route('arsip')->with('createArticle', $msg);
    }

    public function edit_profile(Request $reqdata)
    {
        $UpData = User::where('id', '=', Auth::user()->id)->first();
        if ($reqdata->hasFile('image')) {
            $UpData->update([
                'name' => $reqdata->name,
                'pekerjaan' => $reqdata->pekerjaan,
                'jenis_kelamin' => $reqdata->jenis_kelamin,
                'tinggal' => $reqdata->tinggal,
                'email' => $reqdata->email,
                'password' => bcrypt($reqdata->password),
                'image' => $reqdata->file('image')->move('img\profile', $reqdata->file('image')->getClientOriginalName())
            ]);
        } else {
            $UpData->update([
                'name' => $reqdata->name,
                'pekerjaan' => $reqdata->pekerjaan,
                'jenis_kelamin' => $reqdata->jenis_kelamin,
                'tinggal' => $reqdata->tinggal,
                'email' => $reqdata->email,
                'password' => bcrypt($reqdata->password),
                'image' => $UpData->image
            ]);
        }
        $msg = " Anda berhasil mengubah data profil!!";
        return redirect()->route('profile')->with('updateProfileNotif', $msg);
    }

    public function artikel()
    {
        return view('artikel');
    }

    public function arsip()
    {
        $CanViewArticle = Articles::where('user_id', '=', Auth::user()->id)->where('user_id', '<>', NULL)->distinct()->get();
        $CannotViewArticle = Articles::where('user_id', '<>', Auth::user()->id)->where('user_id', '=', NULL)->distinct()->get();
        
        if($CanViewArticle){
            $readDB = $CanViewArticle->all();

            $data = [
                'data' => $readDB
            ];
            return view('arsip', $data);
        }
        if($CannotViewArticle){
            $readDB = $CannotViewArticle->all();

            $data = [
                'data' => $readDB
            ];
            return view('arsip', $data);
        }
    }

    public function updatearticle(Request $reqdata, $id)
    {
        $findID = Articles::find($id);
        if ($reqdata->hasFile('image')) {
            $findID->update([
                'category_id' => $reqdata->category_id,
                'title' => $reqdata->title,
                'image' => $reqdata->file('image')->move('img\media', $reqdata->file('image')->getClientOriginalName()),
                'content' => $reqdata->content
            ]);
        } else {
            $findID->update([
                'category_id' => $reqdata->category_id,
                'title' => $reqdata->title,
                'image' => "none",
                'content' => $reqdata->content
            ]);
        }
        $msg = " Anda berhasil mengubah data artikel!!";
        return redirect()->route('arsip')->with('updateArticle', $msg);
    }

    public function deletearticle($id)
    {
        $findID = Articles::find($id);
        $findID->delete();
        $max = DB::table('posts')->max('id') + 1;
        DB::statement("ALTER TABLE posts AUTO_INCREMENT =  $max");  
        $msg = ' Selamat anda berhasil menghapus data artikel!!';
        return redirect()->route('arsip')->with('deleteArticle', $msg);
    }

    public function publikasi()
    {
        $readDB = DB::table('posts')->paginate(6);

        $data = [
            'data' => $readDB
        ];
        return view('publikasi', $data);
    }

    public function kategori()
    {
        $khusus = Articles::where('category_id', '=', '1')->distinct();
        $umum = Articles::where('category_id', '=', '2')->distinct();

        $readKhusus = $khusus->paginate(3);
        $readUmum = $umum->paginate(3);

        $data = [
            'khusus' => $readKhusus,
            'umum' => $readUmum
        ];
        return view('kategori', $data);
    }
}