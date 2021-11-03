<?php
namespace App\Exports;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportsTranscriptApps implements FromQuery,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */  
    // use Exportable;
      
    public function headings(): array
    {
        return [
            'Matricno','Name','Email','Phone','State','Country','Programme',
            'Organisation','ContactPerson','ContactEmail',
            'ContactPhone','Address1','Address2','TranscriptLabel',
            'TranscriptID'
      
        ];
    }
    public function query()
    {
        //return UGPreAdmissionReg::query();
        /*you can use condition in query to get required result*/
        return User::query()->select('ap.matricno','users.name',
                                            'ap.email',
                                            'ap.phone',
                                            'de.state',
                                            'de.country',
                                            'programme',
                                            'organization',
                                            'contactperson',
                                            'rd.email',
                                            'rd.phone',
                                            'address1',
                                            'address2',
                                            'transcriptlabel',
                                            'paymentref'
                                                       )
                             ->join('applications as ap', 'users.matricno', '=', 'ap.matricno')
                            ->join('receipentdata as rd', 'users.matricno', '=', 'rd.matricno')
                            ->join('destinationinfo as de', 'de.transcriptid', '=', 'rd.transcriptid')
                            ->join('country as con', 'con.id', '=', 'de.country')
                            ->orderby('rd.created_at','desc');
    }                                   
    public function map($apl): array
    {
        return [
            $apl->matricno,
            $apl->name,
            $apl->email,
            $apl->phone,
            $apl->state,
            $apl->country,
            $apl->programme,
            $apl->organisation,
            $apl->contactperson,
            $apl->email,
            $apl->phone,
            $apl->address1,
            $apl->address2,
            $apl->transcriptlabel,
            $apl->transcriptid
         
        ];
    }

}