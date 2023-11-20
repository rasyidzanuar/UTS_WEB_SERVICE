<?php 

namespace App\Http\Controllers;

use App\Models\Mobil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MobilController extends Controller
{
    public function index(Request $request)
    {
        $acceptHeader = $request->header('Accept');

        if($acceptHeader == 'application/json' || $acceptHeader == 'application/xml'){
            $mobil = Mobil::OrderBy("id", "DESC")->paginate(2);

            if($acceptHeader == 'application/json' || $acceptHeader == 'application/xml'){
                return response()->json($mobil->items('data'), 200);
            }else{
                $xml = new \SimpleXMLElement('<mobil/>');
                foreach ($mobil->items('data')as $item){
                    $xmlItem = $xml->addChild('mobil');

                    $xmlItem->addChild('id',$item->id);
                    $xmlItem->addChild('nama_mobil',$item->nama_mobil);
                    $xmlItem->addChild('harga',$item->harga);
                    $xmlItem->addChild('deskripsi',$item->deskripsi);
                    $xmlItem->addChild('gambar',$item->gambar);
                    $xmlItem->addChild('created_at',$item->created_at);
                    $xmlItem->addChild('updated_at',$item->updated_at);
                }
                return $xml->asXML();
            }
        }else{
            return response('not Accepted', 416);
        }
    }

    public function show(Request $request, $id)
    {
        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $contentTypeHeader = $request->header('Content-Type');

            if ($contentTypeHeader === 'application/json') {
                $mobil = Mobil::find($id);

                if (!$mobil) {
                    abort(404);
                }

                return response()->json($mobil, 200);
            } else {
                return response('Tipe Media Tidak Mendukung!', 415);
            }
        } else {
            return response('Tidak Bisa Diterima!', 406);
        }
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        $mobil = Mobil::find($id);

        if (!$mobil) {
            abort(404);
        }

        $validationRules = [
            'nama_mobil' => 'required',
            'harga' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required',
        ];

        $validator = Validator::make($input, $validationRules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $mobil->fill($input);
        $mobil->save();

        return response()->json($mobil, 200);
    }

    public function store(Request $request){
        $input = $request->all();
        $mobil = Mobil::create($input);

        return response()->json($mobil, 200);
    }


    public function destroy(Request $request, $id)
    {
        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $contentTypeHeader = $request->header('Content-Type');

            if ($contentTypeHeader === 'application/json' || 'application/xml') {
                $mobil = Mobil::find($id);

                if (!$mobil) {
                    abort(404);
                }

                $mobil->delete();
                $message = ['message' => 'delete data berhasil'];

                return response()->json($message, 200);
            } else {
                return response('Tipe Media Tidak Mendukung!', 415);
            }
        } else {
            return response('Tidak Bisa Diterima!', 406);
        }
    }
}