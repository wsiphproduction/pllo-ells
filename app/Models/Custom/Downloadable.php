<?php

namespace App\Models\Custom;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Auth;

class Downloadable extends Model
{
    use HasFactory, SoftDeletes;
    
    public $table = 'downloadables';
    protected $fillable = [ 'type', 'ra_jr_no', 'source_priority_level', 'approved_on', 'congress', 'long_title', 'attachments', 'bill_no', 'proposed_measure', 'bill_status', 'hor_status', 'sen_status', 'status', 'agency', 'cluster', 'created_by'];
    

    public static function hasApprover($agency=null, $cluster=null){
        
        if($agency){
            $a = \App\Models\Agency::find($agency);
            
            if($a->approver){
                return true;
            }
        }

        if($cluster){
            $ids = explode('::', $cluster);

            foreach($ids as $id){
                $c = \App\Models\Cluster::find($id);

                if($c->approver){
                    return true;
                }
            }
        }

        return false;
    }

    public static function userIsApprover($agency=null, $cluster=null){

        $member = \App\Models\Member::where('user_id', Auth::user()->id)->first();

        if($member){
            if($agency){
                if($agency == $member->agency){
                    return true;
                }
            }
            
            if($cluster){
                $m_clusters = explode('::', $member->cluster);
                $e_clusters = explode('::', $cluster);

                foreach($m_clusters as $m_cluster){
                    foreach($e_clusters as $e_cluster){
                        if($m_cluster == $e_cluster){
                            return true;
                        }
                    }
                }
            }
        }
        
        return false;
    }
}
