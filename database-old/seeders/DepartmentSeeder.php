<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Extraction;
use App\Models\Filter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DepartmentSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$dataBilanSQL = "WITH DATA_BILAN_GL_CODE AS (
SELECT 
    gl.parent_gl
    ,gl.GL_CODE
    ,gl_parent.GL_DESC AS \"PARENT_DESCRIPTION\"
    ,e.AC_NO
    ,(
        CASE 
            WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':j' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':j' THEN e.lcy_amount ELSE 0 END, 0)) >= 0 
            THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':j' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':j' THEN e.lcy_amount ELSE 0 END, 0)) 
            ELSE 0 
        END +
        CASE 
            WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':j' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':j' THEN e.lcy_amount ELSE 0 END, 0)) < 0 
            THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':j' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':j' THEN e.lcy_amount ELSE 0 END, 0)) 
            ELSE 0 
        END
    ) AS \"M\"
    ,CASE 
        WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':j' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':j' THEN e.lcy_amount ELSE 0 END, 0)) < 0 
        THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':j' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':j' THEN e.lcy_amount ELSE 0 END, 0)) 
        ELSE 0 
    END AS \"M_DR\"   
    ,CASE 
        WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':j' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':j' THEN e.lcy_amount ELSE 0 END, 0)) >= 0 
        THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':j' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':j' THEN e.lcy_amount ELSE 0 END, 0)) 
        ELSE 0 
    END AS \"M_CR\"

    ,(
        CASE 
            WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-1_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-1_end' THEN e.lcy_amount ELSE 0 END, 0)) >= 0 
            THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-1_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-1_end' THEN e.lcy_amount ELSE 0 END, 0)) 
            ELSE 0 
        END +
        CASE 
            WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-1_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-1_end' THEN e.lcy_amount ELSE 0 END, 0)) < 0 
            THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-1_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-1_end' THEN e.lcy_amount ELSE 0 END, 0)) 
            ELSE 0 
        END
    ) AS \"M_1\"
    ,CASE 
        WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-1_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-1_end' THEN e.lcy_amount ELSE 0 END, 0)) < 0 
        THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-1_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-1_end' THEN e.lcy_amount ELSE 0 END, 0)) 
        ELSE 0 
    END AS \"M_1_DR\"   
    ,CASE 
        WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-1_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-1_end' THEN e.lcy_amount ELSE 0 END, 0)) >= 0 
        THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-1_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-1_end' THEN e.lcy_amount ELSE 0 END, 0)) 
        ELSE 0 
    END AS \"M_1_CR\"
    ,(
        CASE 
            WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-2_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-2_end' THEN e.lcy_amount ELSE 0 END, 0)) >= 0 
            THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-2_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-2_end' THEN e.lcy_amount ELSE 0 END, 0)) 
            ELSE 0 
        END +
        CASE 
            WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-2_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-2_end' THEN e.lcy_amount ELSE 0 END, 0)) < 0 
            THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-2_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-2_end' THEN e.lcy_amount ELSE 0 END, 0)) 
            ELSE 0 
        END
    ) AS \"M_2\"
    ,CASE 
        WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-2_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-2_end' THEN e.lcy_amount ELSE 0 END, 0)) < 0 
        THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-2_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-2_end' THEN e.lcy_amount ELSE 0 END, 0)) 
        ELSE 0 
    END AS \"M_2_DR\"   
    ,CASE 
        WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-2_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-2_end' THEN e.lcy_amount ELSE 0 END, 0)) >= 0 
        THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-2_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-2_end' THEN e.lcy_amount ELSE 0 END, 0)) 
        ELSE 0 
    END AS \"M_2_CR\"


    ,(
        CASE 
            WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_j' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_j' THEN e.lcy_amount ELSE 0 END, 0)) >= 0 
            THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_j' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_j' THEN e.lcy_amount ELSE 0 END, 0)) 
            ELSE 0 
        END +
        CASE 
            WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_j' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_j' THEN e.lcy_amount ELSE 0 END, 0)) < 0 
            THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_j' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_j' THEN e.lcy_amount ELSE 0 END, 0)) 
            ELSE 0 
        END
    ) AS \"EXO_1_M\"
    ,CASE 
        WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_j' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_j' THEN e.lcy_amount ELSE 0 END, 0)) < 0 
        THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_j' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_j' THEN e.lcy_amount ELSE 0 END, 0)) 
        ELSE 0 
    END AS \"DR_EXO_1_M\"   
    ,CASE 
        WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_j' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_j' THEN e.lcy_amount ELSE 0 END, 0)) >= 0 
        THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_j' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_j' THEN e.lcy_amount ELSE 0 END, 0)) 
        ELSE 0 
    END AS \"CR_EXO_1_M\"

    ,(
        CASE 
            WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_end' THEN e.lcy_amount ELSE 0 END, 0)) >= 0 
            THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_end' THEN e.lcy_amount ELSE 0 END, 0)) 
            ELSE 0 
        END +
        CASE 
            WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_end' THEN e.lcy_amount ELSE 0 END, 0)) < 0 
            THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_end' THEN e.lcy_amount ELSE 0 END, 0)) 
            ELSE 0 
        END
    ) AS \"EXO_1\"
    ,CASE 
        WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_end' THEN e.lcy_amount ELSE 0 END, 0)) < 0 
        THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_end' THEN e.lcy_amount ELSE 0 END, 0)) 
        ELSE 0 
    END AS \"DR_EXO_1\"   
    ,CASE 
        WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_end' THEN e.lcy_amount ELSE 0 END, 0)) >= 0 
        THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_end' THEN e.lcy_amount ELSE 0 END, 0)) 
        ELSE 0 
    END AS \"CR_EXO_1\"
FROM ACVW_ALL_AC_ENTRIES e
JOIN GLTM_GLMASTER gl ON gl.GL_CODE(+)=e.AC_NO
JOIN GLTM_GLMASTER gl_parent ON gl.parent_gl = gl_parent.gl_code
WHERE SUBSTR(gl.PARENT_GL, 1, 1) IN ('1', '2', '3', '4', '5', '8', '9')
AND E.VALUE_DT BETWEEN ':activity_start' AND ':j'
GROUP BY gl.parent_gl, gl.GL_CODE, gl_parent.GL_DESC, e.AC_NO

UNION ALL

SELECT 
    gl.parent_gl
    ,gl.GL_CODE
    ,gl_parent.GL_DESC AS \"PARENT_DESCRIPTION\"
    ,e.AC_NO
    ,(
        CASE 
            WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':j' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':j' THEN e.lcy_amount ELSE 0 END, 0)) >= 0 
            THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':j' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':j' THEN e.lcy_amount ELSE 0 END, 0)) 
            ELSE 0 
        END +
        CASE 
            WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':j' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':j' THEN e.lcy_amount ELSE 0 END, 0)) < 0 
            THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':j' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':j' THEN e.lcy_amount ELSE 0 END, 0)) 
            ELSE 0 
        END
    ) AS \"M\"
    ,CASE 
        WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':j' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':j' THEN e.lcy_amount ELSE 0 END, 0)) < 0 
        THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':j' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':j' THEN e.lcy_amount ELSE 0 END, 0)) 
        ELSE 0 
    END AS \"M_DR\"   
    ,CASE 
        WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':j' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':j' THEN e.lcy_amount ELSE 0 END, 0)) >= 0 
        THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':j' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':j' THEN e.lcy_amount ELSE 0 END, 0)) 
        ELSE 0 
    END AS \"M_CR\"
    ,(
        CASE 
            WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-1_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-1_end' THEN e.lcy_amount ELSE 0 END, 0)) >= 0 
            THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-1_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-1_end' THEN e.lcy_amount ELSE 0 END, 0)) 
            ELSE 0 
        END +
        CASE 
            WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-1_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-1_end' THEN e.lcy_amount ELSE 0 END, 0)) < 0 
            THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-1_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-1_end' THEN e.lcy_amount ELSE 0 END, 0)) 
            ELSE 0 
        END
    ) AS \"M_1\"
    ,CASE 
        WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-1_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-1_end' THEN e.lcy_amount ELSE 0 END, 0)) < 0 
        THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-1_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-1_end' THEN e.lcy_amount ELSE 0 END, 0)) 
        ELSE 0 
    END AS \"M_1_DR\"   
    ,CASE 
        WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-1_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-1_end' THEN e.lcy_amount ELSE 0 END, 0)) >= 0 
        THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-1_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-1_end' THEN e.lcy_amount ELSE 0 END, 0)) 
        ELSE 0 
    END AS \"M_1_CR\"
    ,(
        CASE 
            WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-2_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-2_end' THEN e.lcy_amount ELSE 0 END, 0)) >= 0 
            THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-2_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-2_end' THEN e.lcy_amount ELSE 0 END, 0)) 
            ELSE 0 
        END +
        CASE 
            WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-2_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-2_end' THEN e.lcy_amount ELSE 0 END, 0)) < 0 
            THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-2_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-2_end' THEN e.lcy_amount ELSE 0 END, 0)) 
            ELSE 0 
        END
    ) AS \"M_2\"
    ,CASE 
        WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-2_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-2_end' THEN e.lcy_amount ELSE 0 END, 0)) < 0 
        THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-2_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-2_end' THEN e.lcy_amount ELSE 0 END, 0)) 
        ELSE 0 
    END AS \"M_2_DR\"   
    ,CASE 
        WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-2_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-2_end' THEN e.lcy_amount ELSE 0 END, 0)) >= 0 
        THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-2_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':m-2_end' THEN e.lcy_amount ELSE 0 END, 0)) 
        ELSE 0 
    END AS \"M_2_CR\"
    ,(
        CASE 
            WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_j' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_j' THEN e.lcy_amount ELSE 0 END, 0)) >= 0 
            THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_j' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_j' THEN e.lcy_amount ELSE 0 END, 0)) 
            ELSE 0 
        END +
        CASE 
            WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_j' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_j' THEN e.lcy_amount ELSE 0 END, 0)) < 0 
            THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_j' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_j' THEN e.lcy_amount ELSE 0 END, 0)) 
            ELSE 0 
        END
    ) AS \"EXO_1_M\"
    ,CASE 
        WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_j' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_j' THEN e.lcy_amount ELSE 0 END, 0)) < 0 
        THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_j' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_j' THEN e.lcy_amount ELSE 0 END, 0)) 
        ELSE 0 
    END AS \"DR_EXO_1_M\"   
    ,CASE 
        WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_j' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_j' THEN e.lcy_amount ELSE 0 END, 0)) >= 0 
        THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_j' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_j' THEN e.lcy_amount ELSE 0 END, 0)) 
        ELSE 0 
    END AS \"CR_EXO_1_M\"

    ,(
        CASE 
            WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_end' THEN e.lcy_amount ELSE 0 END, 0)) >= 0 
            THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_end' THEN e.lcy_amount ELSE 0 END, 0)) 
            ELSE 0 
        END +
        CASE 
            WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_end' THEN e.lcy_amount ELSE 0 END, 0)) < 0 
            THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                    DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_end' THEN e.lcy_amount ELSE 0 END, 0)) 
            ELSE 0 
        END
    ) AS \"EXO_1\"
    ,CASE 
        WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_end' THEN e.lcy_amount ELSE 0 END, 0)) < 0 
        THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_end' THEN e.lcy_amount ELSE 0 END, 0)) 
        ELSE 0 
    END AS \"DR_EXO_1\"   
    ,CASE 
        WHEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_end' THEN e.lcy_amount ELSE 0 END, 0)) >= 0 
        THEN SUM(DECODE(e.drcr_ind, 'C', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_end' THEN e.lcy_amount ELSE 0 END, 0) - 
                DECODE(e.drcr_ind, 'D', CASE WHEN e.value_dt BETWEEN ':activity_start' AND ':y-1_end' THEN e.lcy_amount ELSE 0 END, 0)) 
        ELSE 0 
    END AS \"CR_EXO_1\"
FROM ACVW_ALL_AC_ENTRIES e
JOIN sttm_cust_account c ON e.AC_NO = c.CUST_AC_NO
JOIN GLTM_GLMASTER gl ON c.DR_GL = gl.GL_CODE
JOIN GLTM_GLMASTER gl_parent ON gl.parent_gl = gl_parent.gl_code
WHERE SUBSTR(gl.PARENT_GL, 1, 1) IN ('1', '2', '3', '4', '5', '8', '9')
AND E.VALUE_DT BETWEEN ':activity_start' AND ':j'
GROUP BY gl.parent_gl, gl.GL_CODE, gl_parent.GL_DESC, e.AC_NO
ORDER BY AC_NO
) select 
    PARENT_GL
    ,PARENT_DESCRIPTION
    ,sum(M)\"M\"
    ,sum(M_CR)\"CR_M\"
    ,sum(M_DR)\"DR_M\"

    ,sum(M_1)\"M_1\"
    ,sum(M_1_CR)\"CR_M_1\"
    ,sum(M_1_DR)\"DR_M_1\"

    ,sum(M_2)\"M_2\"
    ,sum(M_2_CR)\"CR_M_2\"
    ,sum(M_2_DR)\"DR_M_2\"

    ,sum(EXO_1_M)\"EXO_1_M\"
    ,sum(CR_EXO_1_M)\"CR_EXO_1_M\"
    ,sum(DR_EXO_1_M)\"DR_EXO_1_M\"

    ,sum(EXO_1)\"EXO_1\"
    ,sum(CR_EXO_1)\"CR_EXO_1\"
    ,sum(DR_EXO_1)\"DR_EXO_1\"

from DATA_BILAN_GL_CODE

group by PARENT_GL, PARENT_DESCRIPTION
order by PARENT_GL
";

$dataCrSQL = "
select
    'CFN-FINANCE' \"Entite\"
    ,gl_parent.parent_gl \"Parent GL\"
    ,gl_parent.GL_DESC \"Intitulé Parent GL\"
    ,a.AC_NO \"Account number\"
    ,c.GL_DESC AS \"Intitulé Acount number\"
    ,nvl((select( sum(decode(b.drcr_ind, 'C', b.lcy_amount, 0))- sum(decode(b.drcr_ind, 'D', b.lcy_amount, 0))) from CFSFCUBS145.ACVW_ALL_AC_ENTRIES b where b.AC_NO=a.AC_NO  AND b.VALUE_DT BETWEEN ':y_start' AND ':j'),0) \"M\"
    ,nvl((select( sum(decode(b.drcr_ind, 'C', b.lcy_amount, 0))- sum(decode(b.drcr_ind, 'D', b.lcy_amount, 0))) from CFSFCUBS145.ACVW_ALL_AC_ENTRIES b where b.AC_NO=a.AC_NO  AND b.VALUE_DT BETWEEN ':y_start' AND ':m-1_end'),0) \"M_1\"
    ,nvl((select( sum(decode(b.drcr_ind, 'C', b.lcy_amount, 0))- sum(decode(b.drcr_ind, 'D', b.lcy_amount, 0))) from CFSFCUBS145.ACVW_ALL_AC_ENTRIES b where b.AC_NO=a.AC_NO  AND b.VALUE_DT BETWEEN ':y_start' AND ':m-2_end'),0) \"M_2\"
    ,nvl((select( sum(decode(b.drcr_ind, 'C', b.lcy_amount, 0))- sum(decode(b.drcr_ind, 'D', b.lcy_amount, 0))) from CFSFCUBS145.ACVW_ALL_AC_ENTRIES b where b.AC_NO=a.AC_NO  AND b.VALUE_DT BETWEEN ':y-1_start' AND ':y-1_j'),0) \"EXO_1_M\"
    ,nvl((select( sum(decode(b.drcr_ind, 'C', b.lcy_amount, 0))- sum(decode(b.drcr_ind, 'D', b.lcy_amount, 0))) from CFSFCUBS145.ACVW_ALL_AC_ENTRIES b where b.AC_NO=a.AC_NO  AND b.VALUE_DT BETWEEN ':y-1_start' AND ':y-1_end'),0) \"EXO_1\"
from CFSFCUBS145.ACVW_ALL_AC_ENTRIES a
join CFSFCUBS145.gltm_glmaster c  on c.gl_code(+)=a.AC_NO
JOIN GLTM_GLMASTER gl_parent ON c.parent_gl = gl_parent.gl_code
where a.value_dt between ':activity_start' and ':j'  
and SUBSTR(a.AC_NO, 1, 1) IN ('6', '7') 
group by  a.AC_NO, gl_parent.parent_gl, gl_parent.GL_DESC, c.GL_DESC
order by a.AC_NO asc
";

		$extractionFactory = function ($extractionName, $department, $index, $sleepTime = 0, $script = "SELECT * FROM report_tg_2 where VALUE_DATE <= ':date_creation_max'") {
			sleep($sleepTime);
			Extraction::factory(1)->create([
				"department_id" => $department->id,
				"name" => $extractionName,
				"sql_script" => $script,
				"script_id" => 1,
			])->each(function ($extraction) {
				Filter::factory(1)->create(["extraction_id" => $extraction->id, "key" => "date_creation_max", "label" => "Date maximal de création", "type" => "date"]);
				// Filter::factory(1)->create(["extraction_id" => $extraction->id, "key" => "date_de_fin", "label" => "Date de fin", "type" => "date"]);
			});
		};


		Department::factory(1)->create(["name" => "FLEXCUBE"])->each(function ($department) use ($extractionFactory) {
			Extraction::factory(1)->create([
				"department_id" => $department->id,
				"name" => "Comptes par agence",
				"sql_script" => "select * from STTM_CUST_ACCOUNT where BRANCH_CODE=':branch_code'",
				"script_id" => 1,
			])->each(function ($extraction) {
				Filter::factory(1)->create(["extraction_id" => $extraction->id, "key" => "branch_code", "label" => "Agence", "type" => "lov", "lov_id" => 1]);
			});
			Extraction::factory(1)->create([
				"department_id" => $department->id,
				"name" => "Compte",
				"sql_script" => "select * from STTM_CUST_ACCOUNT where CUST_AC_NO=':no_compte'",
				"script_id" => 1,
			])->each(function ($extraction) {
				Filter::factory(1)->create(["extraction_id" => $extraction->id, "key" => "no_compte", "label" => "Numéro de compte", "type" => "text"]);
			});
			
		});

		Department::factory(1)->create(["name" => "FINANCE"])->each(function ($department) use ($dataBilanSQL, $dataCrSQL) {
			Extraction::factory(1)->create([
				"department_id" => $department->id,
				"name" => "DATA-BILAN-:j",
				"sql_script" => $dataBilanSQL,
				"script_id" => 1,
			])->each(function ($extraction) {
				Filter::factory(1)->create(["extraction_id" => $extraction->id, "key" => "activity_start", "label" => "Début d'activité", "type" => "date"]);
				Filter::factory(1)->create(["extraction_id" => $extraction->id, "key" => "m-1_end", "label" => "Fin mois-1", "type" => "date"]);
				Filter::factory(1)->create(["extraction_id" => $extraction->id, "key" => "m-2_end", "label" => "Fin mois-2", "type" => "date"]);
				Filter::factory(1)->create(["extraction_id" => $extraction->id, "key" => "y-1_j", "label" => "Jour J dans Year-1", "type" => "date"]);
				Filter::factory(1)->create(["extraction_id" => $extraction->id, "key" => "y-1_end", "label" => "Fin Year-1", "type" => "date"]);
				Filter::factory(1)->create(["extraction_id" => $extraction->id, "key" => "j", "label" => "Jour J", "type" => "date"]);
			});
			Extraction::factory(1)->create([
				"department_id" => $department->id,
				"name" => "DATA-CR-:j",
				"sql_script" => $dataCrSQL,
				"script_id" => 1,
			])->each(function ($extraction) {
				Filter::factory(1)->create(["extraction_id" => $extraction->id, "key" => "activity_start", "label" => "Date début d'activité", "type" => "date"]);
				Filter::factory(1)->create(["extraction_id" => $extraction->id, "key" => "y_start", "label" => "Date début d'année", "type" => "date"]);
				Filter::factory(1)->create(["extraction_id" => $extraction->id, "key" => "y-1_start", "label" => "Date début d'année -1", "type" => "date"]);
				Filter::factory(1)->create(["extraction_id" => $extraction->id, "key" => "y-1_end", "label" => "Date fin d'année -1", "type" => "date"]);
				Filter::factory(1)->create(["extraction_id" => $extraction->id, "key" => "m-1_end", "label" => "Date fin mois -1", "type" => "date"]);
				Filter::factory(1)->create(["extraction_id" => $extraction->id, "key" => "m-2_end", "label" => "Date fin mois -2", "type" => "date"]);
				Filter::factory(1)->create(["extraction_id" => $extraction->id, "key" => "y-1_j", "label" => "Date du jour dans l'année -1", "type" => "date"]);
				Filter::factory(1)->create(["extraction_id" => $extraction->id, "key" => "j", "label" => "Date du jour dans l'année", "type" => "date"]);
			});
			
			Extraction::factory(1)->create([
				"department_id" => $department->id,
				"name" => "DATA-BILAN-:final_date",
				"sql_script" => $dataBilanSQL,
				"script_id" => 2,
			])->each(function ($extraction) {
				Filter::factory(1)->create(["extraction_id" => $extraction->id, "key" => "activity_start", "label" => "Début d'activité", "type" => "date"]);
				Filter::factory(1)->create(["extraction_id" => $extraction->id, "key" => "final_date", "label" => "Date Finale", "type" => "date"]);
			});
			Extraction::factory(1)->create([
				"department_id" => $department->id,
				"name" => "DATA-CR-:final_date",
				"sql_script" => $dataCrSQL,
				"script_id" => 3,
			])->each(function ($extraction) {
				Filter::factory(1)->create(["extraction_id" => $extraction->id, "key" => "activity_start", "label" => "Début d'activité", "type" => "date"]);
				Filter::factory(1)->create(["extraction_id" => $extraction->id, "key" => "final_date", "label" => "Date Finale", "type" => "date"]);
			});
			
		});

		// $count++;
		// Department::factory(1)->create(["name" => "EXPLOITATION"])->each(function ($department) use ($extractionFactory, $compte_ouverts_script) {
		// 	$extractionNameArray = ["Situation agence", "Nombre client", "Comptes ouverts", "Comptes ouverts par apporteur d'affaire"];
		// 	array_map(fn($extractionName, $index) => $extractionFactory($extractionName, $department, $index + 1, 0, $compte_ouverts_script), $extractionNameArray, $extractionKeyArray = array_keys($extractionNameArray));
		// });
		// $count++;
		// Department::factory(1)->create(["name" => "CREDIT"])->each(function ($department) use ($extractionFactory) {
		// 	$extractionNameArray = ["Production credit", "Crédits en attente de déblocage", "Crédits impayés", "Futur tombées d'echeance", "Descente credit financé", "Descente credit financé avec provision", "PAR", "Requete details du PAR CREDIT", "Requete suivi des echeances impayes", "Credits restructures", "Etat des credits declassés", "Liste des Credits par secteur d'activité", "Etat des provisions"];
		// 	array_map(fn($extractionName, $index) => $extractionFactory($extractionName, $department, $index + 1), $extractionNameArray, $extractionKeyArray = array_keys($extractionNameArray));
		// });
		// $count++;
		// Department::factory(1)->create(["name" => "OPERATIONS"])->each(function ($department) use ($extractionFactory) {
		// 	$extractionNameArray = ["Transfert Envoi", "Transfert Paiement", "En cours dépôt", "Liste des clients", "Sort Cheques", "Virements", "Operations de retrait", "Operations de depot", "Mise en place DAT", "Extraction OMB"];
		// 	array_map(fn($extractionName, $index) => $extractionFactory($extractionName, $department, $index + 1), $extractionNameArray, $extractionKeyArray = array_keys($extractionNameArray));
		// });
		// $count++;
		// Department::factory(1)->create(["name" => "FINANCE"])->each(function ($department) use ($extractionFactory) {
		// 	$extractionNameArray = ["Balance avant cloture", "Balance apres cloture", "Journal", "Grand livre", "Depot", "Balance par rubrique", "Produits et charges", "Journal de compte", "Cmptes de resultat", "Data Bilan", "Data Cr", "Tombee Echeance", "Tombee DAT"];
		// 	array_map(fn($extractionName, $index) => $extractionFactory($extractionName, $department, $index + 1), $extractionNameArray, $extractionKeyArray = array_keys($extractionNameArray));
		// });
		// $count++;
		// Department::factory(1)->create(["name" => "AUDIT"])->each(function ($department) use ($extractionFactory) {
		// 	$extractionNameArray = ["Liste des mandatatires ", "Ouverture de compte", "Liste des profils actifs", "Liste des profils desactivés", "Abonnements OMB non créé dans NAFA", "Abonnements SMS non créé dans NAFA", "Abonnement créé dans NAFA mais non activé", "Abonnement non créé dans l’application", "Abonnement créé dans l’application mais non activé", "Descente credit all statut", "Liste des comptes debiteurs", "Operations de caisse", "Historique des caisses", "Liste des comptes dormants ", "Liste des clients sans photo", "Liste des clients sans signature", "liste des comptes fermes avec solde"];
		// 	array_map(fn($extractionName, $index) => $extractionFactory($extractionName, $department, $index + 1), $extractionNameArray, $extractionKeyArray = array_keys($extractionNameArray));
		// });
		// $count++;
		// Department::factory(1)->create(["name" => "MARKETING"])->each(function ($department) use ($extractionFactory) {
		// 	$extractionNameArray = ["Comptes ouverts", "Liste des clients", "Envoie en fabrication de coficash", "Coficash Receptionné", "Coficash en stock", "Dix plus grand déposant", "Vente coficarte avec pack", "Vente coficarte hors pack", "Liste des comptes créés sans abonnement omb", "Comptes ouverts par agence"];
		// 	array_map(fn($extractionName, $index) => $extractionFactory($extractionName, $department, $index + 1), $extractionNameArray, $extractionKeyArray = array_keys($extractionNameArray));
		// });
		// $count++;
		// Department::factory(1)->create(["name" => "IT"])->each(function ($department) use ($extractionFactory) {
		// 	$extractionNameArray = ["Opérations en attente de validation"];
		// 	array_map(fn($extractionName, $index) => $extractionFactory($extractionName, $department, $index + 1), $extractionNameArray, $extractionKeyArray = array_keys($extractionNameArray));
		// });
	}
}
