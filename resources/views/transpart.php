  <br />

            if (level.ToList().Where(x => x.semester == 2).Count() > 0)
            {
                count++;
                tcu = tcu + (int)level.Where(x => x.semester == 2).Sum(x => x.Courseunit);
                tcp = tcp + (int)level.Where(x => x.semester == 2).Sum(x => x.CoursePoint);

                <h4><strong>@level.ToList()[0].studentLevel Level Second Semester  @level.ToList()[0].AcademicName Session</strong></h4>

                <table class="table table-condensed table-bordered">
                    <tr>
                        <th>SN</th>
                        <th>Course Code</th>
                        <th>Course Title</th>
                        <th>Score</th>
                        <th>Grade</th>
                        <th>Course Unit</th>
                        <th>Course Point</th>
                    </tr>

                    @foreach (var item in level)
                    {
                        count++;

                        if (item.semester == 2)
                        {
                            <tr>
                                <td>@sn2</td>
                                <td>@item.coursecode</td>
                                <td>@item.Coursetitle.ToUpper()</td>

                                <td>@item.Score</td>
                                <td>@item.Grade</td>
                                <td>@item.Courseunit</td>
                                <td>@item.CoursePoint</td>
                            </tr>

                            sn2++;
                        }

                    }

                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>@level.Where(x => x.semester == 2).Sum(x => x.Courseunit) </th>
                        <th>@level.Where(x => x.semester == 2).Sum(x => x.CoursePoint)</th>
                    </tr>
                </table>

                decimal PGPA = (tcp - (int)level.Where(x => x.semester == 2).Sum(x => x.CoursePoint)) / (tcu - (decimal)level.Where(x => x.semester == 2).Sum(x => x.Courseunit));
                decimal GPA = ((int)level.Where(x => x.semester == 2).Sum(x => x.CoursePoint)) / ((decimal)level.Where(x => x.semester == 2).Sum(x => x.Courseunit));
                decimal CGPA = tcp / (decimal)tcu;

                <table class="table table-condensed table-bordered text-left">
                    <tr>
                        <th>Previous GPA = @Math.Round(PGPA, 2)</th>
                        <th>Current GPA = @Math.Round(GPA, 2)</th>
                        <th>Cummulative GPA = @Math.Round(CGPA, 2)</th>
                    </tr>
                </table>

            }




        }
        @*<br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />*@
        <label>Total Credit Point : @Model.Sum(x => x.CoursePoint)</label><br />
        <label>Total Units Registered : @Model.Sum(x => x.Courseunit)</label><br />
        int TCP = (int)Model.Sum(x => x.CoursePoint);
        int TCU = (int)Model.Sum(x => x.Courseunit);
        decimal CGPA_F = TCP / (decimal)TCU;
        <label>CGPA :  @Math.Round(CGPA_F, 2)</label>