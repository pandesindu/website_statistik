<?php

namespace App\Http\Controllers;

use App\Models\UjiAnava;
use Illuminate\Http\Request;

class UjiAnavaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $anava = UjiAnava::all();  
        $jumlahData = UjiAnava::count();

        // sum dan avg data normal
        $sumX1 = UjiAnava::sum('x1');
        $avgX1 = UjiAnava::avg('x1');
        $sumX2 = UjiAnava::sum('x2');
        $avgX2 = UjiAnava::avg('x2');
        $sumX3 = UjiAnava::sum('x3');
        $avgX3 = UjiAnava::avg('x3');

        //mencari count x per kelompok data 
        $nx1 = UjiAnava::count('x1');
        $nx2 = UjiAnava::count('x2');
        $nx3 = UjiAnava::count('x3');

        //jumlah semua data 
        $N = $nx1+ $nx2+ $nx3;

        //jumlah kelompok data 
        $k = 3;

        //selesaikan tabel datanya 
        $sigmaX1kuadrat = 0;
        $sigmaX2kuadrat = 0;
        $sigmaX3kuadrat = 0;
        $sigmaXtotal = 0;
        $sigmaXtotalkuadrat = 0;

      

        for ($i=0; $i < $jumlahData; $i++){
            $X1kuadrat[$i] = $anava[$i]->x1 * $anava[$i]->x1;
            $X2kuadrat[$i] = $anava[$i]->x2 * $anava[$i]->x2;
            $X3kuadrat[$i] = $anava[$i]->x3 * $anava[$i]->x3;

            $sigmaX1kuadrat += $X1kuadrat[$i];
            $sigmaX2kuadrat += $X2kuadrat[$i];
            $sigmaX3kuadrat += $X3kuadrat[$i];

            // mencari Xtotal
            $Xtotal[$i] = $anava[$i]->x1 + $anava[$i]->x2 + $anava[$i]->x3;
            $XtotalKuadrat[$i] =  $Xtotal[$i] * $Xtotal[$i];

            $sigmaXtotal += $Xtotal[$i];
            $sigmaXtotalkuadrat += $XtotalKuadrat[$i];
        }
    

        //mencari JKa (Jumlah Kuadrat Antara) rumus sigma xperkelompok * n x per kelompok
        if($nx1 !== 0 ){
            $a1 =  ($sumX1/$nx1);
        }else {
            $a1 = 0;
        }

        if($nx2 !== 0 ){
            $a2 =  ($sumX2/$nx2);
        }else {
            $a2 = 0;
        }

        
        if($nx3 !== 0 ){
            $a3 =  ($sumX3/$nx3);
        }else {
            $a3 = 0;
        }

        if($N !== 0 ){
            $a4 =  ($sigmaXtotal/$N);
        }else {
            $a4 = 0;
        }


        $JKA =  $a1 + $a2 + $a3 - $a4;

     // mencari DKA 
        $DKA = $k - 1;

        // mencari RJKA Rerata Jumlah Kuadrat Antara
        if($DKA !== 0 ){
            $RJKA = $JKA/$DKA;
        } else {
            $RJKA = 0;
        }
        

        // mencari JKt
        $sigmaYkuadrat = $sigmaX1kuadrat + $sigmaX2kuadrat + $sigmaX3kuadrat;

        if ($N !== 0) { 
            $JKT = $sigmaYkuadrat - (($sigmaXtotal * $sigmaXtotal)/$N);
        } else {
            $JKT =0;
        }  
        

        //mencari  Jumlah Kuadrat Dalam (JKD)
        $JKD = $JKT - $JKA;

        //mencari DKD
        $DKD = $N - $k;

        // mencari RJKD Rerata Jumlah Kuadrat Dalam
        if($DKD !== 0) { 
            $RJKD = $JKD/$DKD;  
        } else {
            $RJKD = 0;
        }
        

        // uji F
        if($RJKD !== 0 ){ 
            $F = $RJKA/ $RJKD;
        }else{
            $F = 0;
        }
        

        $DKT = $DKD + $DKA;

        // dd($F);


        return view('ujianava', ['anava' => $anava,
                                'jumlahData'=>$jumlahData,

                                'x1kuadrat' => $X1kuadrat,
                                'x2kuadrat'=> $X2kuadrat,
                                'x3kuadrat'=>$X3kuadrat,
                                'xtotal'=>$Xtotal,
                                'xtotalkuadrat' =>$XtotalKuadrat,

                                'sumX1' =>$sumX1,
                                'sumX2' =>$sumX2,
                                'sumX3' =>$sumX3,
                                'avgX1' =>$avgX1,
                                'avgX2' =>$avgX2,
                                'avgX3' =>$avgX3,
                                'sumxtotal'=>$sigmaXtotal,
                                'sumxtotalkuadrat'=>$sigmaXtotalkuadrat,

                                'sigmaX1kuadrat' => $sigmaX1kuadrat,
                                'sigmaX2kuadrat' => $sigmaX2kuadrat,
                                'sigmaX3kuadrat' => $sigmaX3kuadrat,

                                // antar
                                'JKA' => $JKA,
                                'DKA'=>$DKA,
                                'RJKA'=>$RJKA,
                                'F'=>$F,

                                //dalam 
                                'jkd' => $JKD, 
                                'dkd'=> $DKD,
                                'rjkd' => $RJKD,

                                // total 
                                'jkt' => $JKT, 
                                'dkt' => $DKT, 
                                

                                ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}