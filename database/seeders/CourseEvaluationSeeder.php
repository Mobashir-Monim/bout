<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CourseEvaluation as CE;
use App\Models\CourseEvaluationMatrix as CEM;
use Excel;
use App\Imports\SeedImport;

class CourseEvaluationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $factor = [
            'id' => '2020-summer',
            'factors' => '{"lq":{"name":"Lecture Quality","description":"quantitative measure of the quality of the content provided","maxVal":0,"minVal":0,"diff":0},"cq":{"name":"Course Quality","description":"quantitative measure of the number of additional content and its effectiveness","maxVal":0,"minVal":0,"diff":0},"le":{"name":"Lecture Effort","description":"quantitative measure of the effort put into creating the course content","maxVal":0,"minVal":0,"diff":0},"ae":{"name":"Assessment Effort","description":"quantitative measure of the effort put into grading/examination","maxVal":0,"minVal":0,"diff":0},"lx":{"name":"Learning Experince Effort","description":"quantitative measure of the effort put in to ensure overall better learning experience for the students","maxVal":0,"minVal":0,"diff":0},"sp":{"name":"Student pressure factor","description":"the perceived pressure created on the students by the course","maxVal":0,"minVal":0,"diff":0},"ca":{"name":"Course Administration","description":"a rating of the administration of the course","maxVal":0,"minVal":0,"diff":0},"fr":{"name":"Faculty Recommendations","description":"the number of recommendations received by the faculty","maxVal":0,"minVal":0,"diff":0},"rf":{"name":"Red Flags","description":"the number of prohibited actions taken by the faculty","maxVal":0,"minVal":0,"diff":0},"ta":{"name":"Technical Aptitude","description":"the quantitative measure of the skill level of using technology","maxVal":0,"minVal":0,"diff":0},"cr":{"name":"Course Rating","description":"the quantitative measure of the rating of the course","maxVal":0,"minVal":0,"diff":0},"lr":{"name":"Lab Rating","description":"the quantitative measure of the rating of the lab","maxVal":0,"minVal":0,"diff":0},"dk":{"name":"Domain Knowledge","description":"the quantitative measure of the domain knowledge of the faculty","maxVal":0,"minVal":0,"diff":0},"ldk":{"name":"Lab Faculty Domain Knowledge","description":"the quantitative measure of the domain knowledge of the lab faculty","maxVal":0,"minVal":0,"diff":0},"lfe":{"name":"Lab Faculty Effort","description":"the quantitative measure of the effort of the lab faculty","maxVal":0,"minVal":0,"diff":0},"llx":{"name":"Lab Learning Experince Effort","description":"quantitative measure of the effort put in to ensure overall better learning experience for the students","maxVal":0,"minVal":0,"diff":0},"ii":{"name":"Irresponsibility Indicator","description":"quantitative measure of irresponsibility index based on evaluation","maxVal":0,"minVal":0,"diff":0},"ei":{"name":"Excellence Indicator","description":"quantitative measure of excellence index based on evaluation","maxVal":0,"minVal":0,"diff":0}}',
        ];

        CE::create($data);

        $rows = Excel::toArray(new SeedImport, str_replace('storage', 'public\sample-files', storage_path('Eval Uploadables - matrix.xlsx')))[0];
        $matrix = [];

        foreach ($rows as $key => $row) {
            if (array_key_exists($row[0], $matrix)) {
                $matrix[$row[0]] = ['type' => $row[1], 'calc' => $row[2], 'options' => []];
            }

            $matrix[$row[0]]['options'][$row[3]] = [];

            foreach (explode(',', str_replace(' ', '', $row[4])) as $key => $an) {
                $an = explode(':', $an);
                $matrix[$row[0]]['options'][$row[3]][$an[0]] = $an[1];
            }
        }
    }
}
