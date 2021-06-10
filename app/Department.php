<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public static function defaultDepartments()
    {
        return [
            ['name'=>'BAHAGIAN TEKNOLOGI MAKLUMAT & KOMUNIKASI','description'=>'bahagian teknologi maklumat & komunikasi'],
            ['name'=>'PEJABAT KETUA MENTERI','description'=>'pejabat ketua menteri'],
            ['name'=>'TABUNG AMANAH PENDIDIKAN NEGERI MELAKA','description'=>'tabung amanah pendidikan negeri melaka'],
            ['name'=>'BAHAGIAN PENGURUSAN SUMBER MANUSIA','description'=>'bahagian pengurusan sumber manusia'],
            ['name'=>'BAHAGIAN KOMUNIKASI KORPORAT','description'=>'bahagian komunikasi korporat'],
            ['name'=>'BAHAGIAN KHIDMAT PENGURUSAN','description'=>'bahagian khidmat pengurusan'],
            ['name'=>'UNIT PERANCANG EKONOMI NEGERI','description'=>'unit perancang ekonomi negeri'],
            ['name'=>'UNIT KERAJAAN TEMPATAN','description'=>'unit kerajaan tempatan'],
            ['name'=>'BAHAGIAN PROMOSI PELANCONGAN','description'=>'bahagian promosi pelancongan'],
            ['name'=>'MAJLIS SUKAN NEGERI','description'=>'majlis sukan negeri'],
            ['name'=>'BADAN KAWAL SELIA AIR','description'=>'badan kawal selia air'],
            ['name'=>'BAHAGIAN AUDIT DALAM DAN SIASATAN AWAM','description'=>'bahagian audit dalam dan siasatan awam'],
            ['name'=>'PERBADANAN KETUA MENTERI','description'=>'perbadanan ketua menteri'],
            ['name'=>'PEJABAT TIMBALAN SETIAUSAHA KERAJAAN (PENGURUSAN)','description'=>'pejabat timbalan setiausaha kerajaan (pengurusan)'],
            ['name'=>'MAJLIS PEMBANGUNAN PULAU-PULAU MELAKA','description'=>'majlis pembangunan pulau-pulau melaka'],
            ['name'=>'PEJABAT SETIAUSAHA KERAJAAN NEGERI','description'=>'pejabat setiausaha kerajaan negeri'],
            ['name'=>'UNIT DEWAN DAN MMKN','description'=>'unit dewan dan mmkn'],
            ['name'=>'BAHAGIAN KORIDOR INFRASTRUKTUR DAN IMPAK SOSIAL','description'=>'bahagian koridor infrastruktur dan impak sosial'],
            ['name'=>'PEJABAT PEMANTAUAN DAN PELAKSANAAN NEGERI MELAKA','description'=>'pejabat pemantauan dan pelaksanaan negeri melaka'],
            ['name'=>'UNIT INTEGRITI','description'=>'unit integriti'],
            ['name'=>'MAJLIS PEMBANGUNAN MALACCA WATER FRONT ECONOMIC ZONE (MPMWEZ)','description'=>'majlis pembangunan malacca water front economic zone (mpmwez)'],
            ['name'=>'BAHAGIAN KHIDMAT MUSAADAH','description'=>'bahagian khidmat musaadah'],
            ['name'=>'PEJABAT TIMBALAN SETIAUSAHA KERAJAAN (PEMBANGUNAN)','description'=>'pejabat timbalan setiausaha kerajaan (pembangunan)'],
            ['name'=>'BAHAGIAN PENGURUSAN KEWANGAN','description'=>'bahagian pengurusan kewangan'],
        ];
    }
}
