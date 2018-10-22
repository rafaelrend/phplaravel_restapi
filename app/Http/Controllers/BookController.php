<?php

namespace App\Http\Controllers;

use Illuminate\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Book;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index()
    {
             $sql = "select * from book order by title ";

         $itens = DB::select($sql);

         return $itens;
    }

    public function testpost(Request $request){
        
        
                         $msg = $request->input( "msg");
                         
                         $txt = "Recebido um post. A msg é: ". $msg;
                         
                         return $txt;
    }
    

    public function grid(Request $request){
        
        
                         $filtro = ""; $str_filt = "";

                         $page = $request->input( "page");
                         $pagesize = $request->input( "pagesize");  

                         if ( $pagesize == "")
                            $pagesize = 10;

                         if ( $page == "")
                            $page = 1;

                        if ( $request->input( "filtro")  != ""){
                            $str_filt = str_replace("'","''", $request->input( "filtro") );
                            $filtro .= " and ( b.title like '%".$str_filt."%' or b.isbn like '%".$str_filt."%')  ";
                        }

                         if ( $request->input( "author_id")  != ""){
                            $str_filt = str_replace("'","''", $request->input( "author_id") );
                            $filtro .= " and b.author_id = " . $str_filt;  
                         }


                         $sql = " select count(*) as res from book b where 1 = 1 ".$filtro ;
                         $total_itens = $this->executeScalar(  $sql );

                         $inicio = 0; $fim = 0;
                         $this->SetaRsetPaginacao($pagesize, $page,$total_itens, $inicio, $fim);

                         $order = $request->input("order");
                         $order_type = $request->input("order_type");
                         if ( $order == ""){
                            $order = "id";
                         }
                          if ( $order_type == ""){
                            $order_type = "asc";
                         }

                         $sql = "select b.*, a.name as author_name from book b
                                    left join author a on a.id = b.author_id
                                    where 1 = 1 ". $filtro .
                                 " order by ".$order. " ".$order_type . " limit " . $inicio. ", ". $pagesize ;
                         $itens = DB::select($sql);


                         $saida = array("page"=>$page, "pagesize" => $pagesize, "order"=>$order,
                          "total"=>$total_itens, "total_itens"=> $total_itens,
                          "order_type"=> $order_type, "itens" => $itens );

                         return $saida;
        
        
    }

    public function show($id)
    {
        if (!$id) {
           throw new HttpException(400, "Invalid id");
        }

        $book = Book::find($id);

        return response()->json([
            $book,
        ], 200);

    }

    public function store(Request $request)
    {
        $reg = new Book;
        $this->loadRequest($request, $reg );

           $ret = $reg->save();

           $msg = "sucesso!"; $code = 1;
           if (! $ret  ){
                  $code = 0;
                  $msg = "erro";
           }

        return array("msg"=>$msg, "code" =>  $code , "success" => $ret, "results"=> $reg);

    }

    public function getValueRequest(Request $request, $prop){

             $valor = $request->input( $prop);

             if ( $valor == "null")
                return null;

            return $request->input( $prop);

    }

    public function loadRequest(Request $request, &$reg){


        $reg->title = $this->getValueRequest($request, 'title' );
        $reg->price = $this->getValueRequest($request, 'price' ) ;
        $reg->editor = $this->getValueRequest($request, 'editor' );
        $reg->author_id = $this->getValueRequest($request, 'author_id' ) ;
        $reg->price = $this->getValueRequest($request, 'price' );
        $reg->stock = $this->getValueRequest($request, 'stock' );
        $reg->isbn = $this->getValueRequest($request, 'isbn' );
        $reg->date_release = $this->getValueRequest($request, 'date_release' );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        if (!$id) {
            throw new HttpException(400, "Invalid id");
        }

        $reg = Book::find($id);

        $this->loadRequest($request, $reg );

        $ret = $reg->save();

             $msg = "sucesso!"; $code = 1;
            if (! $ret  ){
                  $code = 0;
                  $msg = "erro";
            }

        return array("msg"=>$msg, "code" =>  $code , "success" => $ret, "results"=> $reg);
    }

    public function destroy($id, Request $request)
    {
        $reg = Book::find($id);
        $ret = $reg->delete();
        return array("msg"=>"sucesso", "code" =>  1 , "success" => $ret, "results"=> $reg);
    }
}
