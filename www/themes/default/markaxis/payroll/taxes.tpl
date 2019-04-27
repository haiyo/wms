
<div class="tab-pane" id="taxes">
    <div class="panel-heading">
        <h5 class="panel-title">&nbsp;<a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li>
                    <a type="button" class="btn bg-purple-400 btn-labeled"
                       data-backdrop="static" data-keyboard="false"
                       data-toggle="modal" data-target="#modalTaxGroup">
                        <b><i class="icon-folder-plus"></i></b> Create New Tax Group
                    </a>
                </li>
                <li>
                    <a type="button" class="btn bg-purple-400 btn-labeled" data-toggle="modal"
                       data-backdrop="static" data-keyboard="false"
                       data-target="#modalTaxRule">
                        <b><i class="icon-library2"></i></b> Create New Tax Rule
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="">


        <div class="list-group list-group-root border-top border-top-grey">
            <!-- BEGIN DYNAMIC BLOCK: noGroup -->
            <div class="blankCanvasNotice">
                <h6>Hooray! No Tax!</h6>
            </div>
            <!-- END DYNAMIC BLOCK: noGroup -->
            <?TPL_GROUP_TREE_LIST?>

            <div id="taxRulesWrapper"></div>

            <!--
            <div class="list-group collapse" id="item-1">
                <div class="header-elements-inline">
                    <a href="#item-1-1" class="list-group-item" data-toggle="collapse">
                        <i class="glyphicon glyphicon-chevron-right"></i>Employer contribution to Employee CPF
                    </a>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                            <a class="list-icons-item"><i class="icon-bin"></i></a>
                        </div>
                    </div>
                </div>


                <div class="list-group collapse" id="item-1-1">

                    <div class="header-elements-inline">
                        <div class="list-group-item" data-toggle="collapse">
                            Employee age less than 55 years old<br />
                            <span class="badge badge-primary badge-criteria">Criteria: Employee Age</span>
                            <span class="badge badge-warning">17% Employer Contribution</span>
                        </div>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                <a class="list-icons-item"><i class="icon-bin"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="header-elements-inline">
                        <div class="list-group-item" data-toggle="collapse">
                            Employee age 55 to 60  years old<br />
                            <span class="badge badge-primary badge-criteria">Criteria: Employee Age</span>
                            <span class="badge badge-warning">3% Employer Contribution</span>
                        </div>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                <a class="list-icons-item"><i class="icon-bin"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="header-elements-inline">
                        <a href="#item-1-1" class="list-group-item" data-toggle="collapse">
                            Employee age 60 to 65  years old<br />
                            <span class="badge badge-primary badge-criteria">Criteria: Employee Age</span>
                            <span class="badge badge-warning">9% Employer Contribution</span>
                        </a>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                <a class="list-icons-item"><i class="icon-bin"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="header-elements-inline">
                        <a href="#item-1-1" class="list-group-item" data-toggle="collapse">
                            Employee age more than 65  years old<br />
                            <span class="badge badge-primary badge-criteria">Criteria: Employee Age</span>
                            <span class="badge badge-warning">7.5% Employer Contribution</span>
                        </a>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                <a class="list-icons-item"><i class="icon-bin"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="header-elements-inline">
                    <a href="#item-1-2" class="list-group-item" data-toggle="collapse">
                            <i class="glyphicon glyphicon-chevron-right"></i>Employee contribution to CPF
                    </a>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                            <a class="list-icons-item"><i class="icon-bin"></i></a>
                        </div>
                    </div>
                </div>

                <div class="list-group collapse" id="item-1-2">

                    <div class="header-elements-inline">
                        <a href="#item-1-1" class="list-group-item" data-toggle="collapse">
                            Age less than 55  years old<br />
                            <span class="badge badge-primary badge-criteria">Criteria: Employee Age</span>
                            <span class="badge badge-success">20% Salary Deduction</span>
                        </a>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                <a class="list-icons-item"><i class="icon-bin"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="header-elements-inline">
                        <a href="#item-1-1" class="list-group-item" data-toggle="collapse">
                            Age 55 to 60  years old<br />
                            <span class="badge badge-primary badge-criteria">Criteria: Employee Age</span>
                            <span class="badge badge-success">13% Salary Deduction</span>
                        </a>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                <a class="list-icons-item"><i class="icon-bin"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="header-elements-inline">
                        <a href="#item-1-1" class="list-group-item" data-toggle="collapse">
                            Age 60 to 65  years old<br />
                            <span class="badge badge-primary badge-criteria">Criteria: Employee Age</span>
                            <span class="badge badge-success">7.5% Salary Deduction</span>
                        </a>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                <a class="list-icons-item"><i class="icon-bin"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="header-elements-inline">
                        <a href="#item-1-1" class="list-group-item" data-toggle="collapse">
                            Age more than 65  years old<br />
                            <span class="badge badge-primary badge-criteria">Criteria: Employee Age</span>
                            <span class="badge badge-success">5% Salary Deduction</span>
                        </a>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                <a class="list-icons-item"><i class="icon-bin"></i></a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <div class="header-elements-inline">
                <a href="#item-2" class="list-group-item" data-toggle="collapse">
                    <i class="glyphicon glyphicon-chevron-right"></i><span class="title">Self-Help Groups (SHGs)</span><br />
                    <div class="description text-muted">Employees are required to contribute monthly to the SHGs Funds.
                        The SHGs are set up to uplift the less privileged and low income households in the Chinese, Eurasian,
                        Muslim and Indian communities, respectively.</div>
                </a>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                        <a class="list-icons-item"><i class="icon-bin"></i></a>
                    </div>
                </div>
            </div>

            <div class="list-group collapse" id="item-2">
                <div class="header-elements-inline">
                    <a href="#item-2-1" class="list-group-item" data-toggle="collapse">
                        <i class="glyphicon glyphicon-chevron-right"></i>
                        Chinese Development Assistance Council (CDAC)
                    </a>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                            <a class="list-icons-item"><i class="icon-bin"></i></a>
                        </div>
                    </div>
                </div>

                <div class="list-group collapse" id="item-2-1">
                    <div class="header-elements-inline">
                        <a href="#" class="list-group-item" data-toggle="collapse">
                            CDAC Salary less than $2,000<br />
                            <span class="badge badge-primary badge-criteria">Criteria: Employee Salary</span>
                            <span class="badge badge-success">SGD$0.50 Salary Deduction</span>
                        </a>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                <a class="list-icons-item"><i class="icon-bin"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="header-elements-inline">
                        <a href="#" class="list-group-item" data-toggle="collapse">
                            CDAC Salary more than $2,000 to $3,500<br />
                            <span class="badge badge-primary badge-criteria">Criteria: Employee Salary</span>
                            <span class="badge badge-success">SGD$1.00 Salary Deduction</span>
                        </a>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                <a class="list-icons-item"><i class="icon-bin"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="header-elements-inline">
                        <a href="#" class="list-group-item" data-toggle="collapse">
                            CDAC Salary more than $3,500 to $5,000<br />
                            <span class="badge badge-primary badge-criteria">Criteria: Employee Salary</span>
                            <span class="badge badge-success">SGD$1.50 Salary Deduction</span>
                        </a>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                <a class="list-icons-item"><i class="icon-bin"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="header-elements-inline">
                        <a href="#" class="list-group-item" data-toggle="collapse">
                            CDAC Salary more than $5,000 to $7,500<br />
                            <span class="badge badge-primary badge-criteria">Criteria: Employee Salary</span>
                            <span class="badge badge-success">SGD$2.00 Salary Deduction</span>
                        </a>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                <a class="list-icons-item"><i class="icon-bin"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="header-elements-inline">
                        <a href="#" class="list-group-item" data-toggle="collapse">
                            CDAC Salary more than $7,500<br />
                            <span class="badge badge-primary badge-criteria">Criteria: Employee Salary</span>
                            <span class="badge badge-success">SGD$3.00 Salary Deduction</span>
                        </a>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                <a class="list-icons-item"><i class="icon-bin"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="header-elements-inline">
                    <a href="#item-2-2" class="list-group-item" data-toggle="collapse">
                        <i class="glyphicon glyphicon-chevron-right"></i>Eurasian Community Fund (ECF)
                    </a>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                            <a class="list-icons-item"><i class="icon-bin"></i></a>
                        </div>
                    </div>
                </div>

                <div class="list-group collapse" id="item-2-2">
                    <div class="header-elements-inline">
                        <a href="#item-3-1" class="list-group-item" data-toggle="collapse">
                            ECF Salary less than $1,000<br />
                            <span class="badge badge-primary badge-criteria">Criteria: Employee Salary</span>
                            <span class="badge badge-success">Salary Deduction</span>
                        </a>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                <a class="list-icons-item"><i class="icon-bin"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="header-elements-inline">
                        <a href="#item-3-2" class="list-group-item" data-toggle="collapse">
                            ECF Salary more than $1,000 to $1,500<br />
                            <span class="badge badge-primary badge-criteria">Criteria: Employee Salary</span>
                            <span class="badge badge-success">Salary Deduction</span>
                        </a>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                <a class="list-icons-item"><i class="icon-bin"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="header-elements-inline">
                        <a href="#item-3-3" class="list-group-item" data-toggle="collapse">
                            ECF Salary more than $1,500 to $2,500<br />
                            <span class="badge badge-primary badge-criteria">Criteria: Employee Salary</span>
                            <span class="badge badge-success">Salary Deduction</span>
                        </a>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                <a class="list-icons-item"><i class="icon-bin"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="header-elements-inline">
                        <a href="#item-3-3" class="list-group-item" data-toggle="collapse">
                            ECF Salary more than $2,500 to $4,000<br />
                            <span class="badge badge-primary badge-criteria">Criteria: Employee Salary</span>
                            <span class="badge badge-success">Salary Deduction</span>
                        </a>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                <a class="list-icons-item"><i class="icon-bin"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="header-elements-inline">
                        <a href="#item-3-3" class="list-group-item" data-toggle="collapse">
                            ECF Salary more than $4,000 to $7,000<br />
                            <span class="badge badge-primary badge-criteria">Criteria: Employee Salary</span>
                            <span class="badge badge-success">Salary Deduction</span>
                        </a>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                <a class="list-icons-item"><i class="icon-bin"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="header-elements-inline">
                        <a href="#item-3-3" class="list-group-item" data-toggle="collapse">
                            ECF Salary more than $7,000 to $10,000<br />
                            <span class="badge badge-primary badge-criteria">Criteria: Employee Salary</span>
                            <span class="badge badge-success">Salary Deduction</span>
                        </a>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                <a class="list-icons-item"><i class="icon-bin"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="header-elements-inline">
                        <a href="#item-3-3" class="list-group-item" data-toggle="collapse">
                            ECF Salary more than $10,000<br />
                            <span class="badge badge-primary badge-criteria">Criteria: Employee Salary</span>
                            <span class="badge badge-success">Salary Deduction</span>
                        </a>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                <a class="list-icons-item"><i class="icon-bin"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="header-elements-inline">
                    <a href="#2-3" class="list-group-item" data-toggle="collapse">
                        <i class="glyphicon glyphicon-chevron-right"></i>
                        Mosque Building and Mendaki Fund (MBMF)
                    </a>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                            <a class="list-icons-item"><i class="icon-bin"></i></a>
                        </div>
                    </div>
                </div>

                <div class="header-elements-inline">
                    <a href="#2-4" class="list-group-item" data-toggle="collapse">
                        <i class="glyphicon glyphicon-chevron-right"></i>
                        Singapore Indian Development Association (SINDA)
                    </a>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                            <a class="list-icons-item"><i class="icon-bin"></i></a>
                        </div>
                    </div>
                </div>

            </div>


            <div class="header-elements-inline">
                <a href="#item-3" class="list-group-item" data-toggle="collapse">
                    <i class="glyphicon glyphicon-chevron-right"></i><span class="title">Skill Development Levy (SDL)</span><br />
                    <div class="description text-muted">Skills Development Levy (SDL) is a compulsory levy that you have to pay for
                        all your employees working in Singapore, on top of CPF contribution and Foreign Worker Levy. CPF Board
                        collects SDL on behalf of the SkillsFuture Singapore Agency (SSG)*.
                    </div>
                </a>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                        <a class="list-icons-item"><i class="icon-bin"></i></a>
                    </div>
                </div>
            </div>

            <div class="list-group collapse" id="item-3">

                <div class="header-elements-inline">
                    <a href="#item-3-1" class="list-group-item" data-toggle="collapse">
                        Salary more than $800<br />
                        <span class="badge badge-primary badge-criteria">Criteria: Employee Salary</span>
                        <span class="badge badge-success">0.25% Salary Deduction</span>
                    </a>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                            <a class="list-icons-item"><i class="icon-bin"></i></a>
                        </div>
                    </div>
                </div>

                <div class="header-elements-inline">
                    <a href="#item-3-2" class="list-group-item" data-toggle="collapse">
                        Salary more than $4,500<br />
                        <span class="badge badge-primary badge-criteria">Criteria: Employee Salary</span>
                        <span class="badge badge-success">SGD$11.25 Salary Deduction</span>
                    </a>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                            <a class="list-icons-item"><i class="icon-bin"></i></a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="header-elements-inline">
                <a href="#item-4" class="list-group-item" data-toggle="collapse">
                    <i class="glyphicon glyphicon-chevron-right"></i><span class="title">Foreign Worker Levy (FWL)</span><br />
                    <div class="description text-muted">The foreign worker levy, commonly known as “levy”, is a pricing mechanism to regulate the
                        number of foreign workers in Singapore. As an employer, you don’t have to pay Central Provident Fund (CPF)
                        contributions for foreign workers. However, you must pay a monthly levy for Work Permit holders.
                    </div>
                </a>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                        <a class="list-icons-item"><i class="icon-bin"></i></a>
                    </div>
                </div>
            </div>

            <div class="list-group collapse" id="item-4">
                <div class="header-elements-inline">
                    <a href="#item-4-1" class="list-group-item" data-toggle="collapse">
                        <i class="glyphicon glyphicon-chevron-right"></i>Construction
                    </a>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                            <a class="list-icons-item"><i class="icon-bin"></i></a>
                        </div>
                    </div>
                </div>

                <div class="list-group collapse" id="item-4-1">
                    <div class="header-elements-inline">
                        <a href="#" class="list-group-item" data-toggle="collapse">
                            Malaysians and North Asian sources (NAS) - Higher-Skilled<br />
                            <span class="badge badge-primary badge-criteria">Criteria: Employee Competencies</span>
                            <span class="badge badge-warning">SGD$300/month Employer Levy</span>
                        </a>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                <a class="list-icons-item"><i class="icon-bin"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="header-elements-inline">
                        <a href="#" class="list-group-item" data-toggle="collapse">
                            Malaysians and North Asian sources (NAS) - Basic-Skilled<br />
                            <span class="badge badge-primary badge-criteria">Criteria: Employee Competencies</span>
                            <span class="badge badge-warning">SGD$700/month Employer Levy</span>
                        </a>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                <a class="list-icons-item"><i class="icon-bin"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="header-elements-inline">
                        <a href="#" class="list-group-item" data-toggle="collapse">
                            Non-traditional sources (NTS) and PRC - Higher-Skilled, on Man-Year Entitlement (MYE)<br />
                            <span class="badge badge-primary badge-criteria">Criteria: Employee Competencies</span>
                            <span class="badge badge-warning">SGD$300/month Employer Levy</span>
                        </a>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                <a class="list-icons-item"><i class="icon-bin"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="header-elements-inline">
                        <a href="#" class="list-group-item" data-toggle="collapse">
                            Non-traditional sources (NTS) and PRC – Basic-Skilled, on Man-Year Entitlement (MYE)<br />
                            <span class="badge badge-primary badge-criteria">Criteria: Employee Competencies</span>
                            <span class="badge badge-warning">SGD$700/month Employer Levy</span>
                        </a>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                <a class="list-icons-item"><i class="icon-bin"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="header-elements-inline">
                        <a href="#" class="list-group-item" data-toggle="collapse">
                            Non-traditional sources (NTS) and PRC – Higher-Skilled, Man-Year Entitlement (MYE) waiver<br />
                            <span class="badge badge-primary badge-criteria">Criteria: Employee Competencies</span>
                            <span class="badge badge-warning">SGD$600/month Employer Levy</span>
                        </a>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                <a class="list-icons-item"><i class="icon-bin"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="header-elements-inline">
                        <a href="#" class="list-group-item" data-toggle="collapse">
                            Non-traditional sources (NTS) and PRC – Basic-Skilled, Man-Year Entitlement (MYE) waiver<br />
                            <span class="badge badge-primary badge-criteria">Criteria: Employee Competencies</span>
                            <span class="badge badge-warning">SGD$950/month Employer Levy</span>
                        </a>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                <a class="list-icons-item"><i class="icon-bin"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="header-elements-inline">
                    <a href="#item-4-2" class="list-group-item" data-toggle="collapse">
                        <i class="glyphicon glyphicon-chevron-right"></i>Manufacturing
                    </a>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                            <a class="list-icons-item"><i class="icon-bin"></i></a>
                        </div>
                    </div>
                </div>

                <div class="list-group collapse" id="item-4-2">
                    <div class="header-elements-inline">
                        <a href="#item-4-2-1" class="list-group-item" data-toggle="collapse">
                            <i class="glyphicon glyphicon-chevron-right"></i>Tier 1: Up to 25% of the total workforce
                        </a>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                <a class="list-icons-item"><i class="icon-bin"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="list-group collapse" id="item-4-2-1">
                        <div class="header-elements-inline">
                            <a href="#" class="list-group-item" data-toggle="collapse">
                                Basic skilled – Monthly<br />
                                <span class="badge badge-primary badge-criteria">Criteria: Up to 25% of Total Workforce, Employee Competencies</span>
                                <span class="badge badge-warning">SGD$370/month Employer Levy</span>
                            </a>
                            <div class="header-elements">
                                <div class="list-icons">
                                    <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                    <a class="list-icons-item"><i class="icon-bin"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="header-elements-inline">
                            <a href="#" class="list-group-item" data-toggle="collapse">
                                Basic skilled – Daily<br />
                                <span class="badge badge-primary badge-criteria">Criteria: Up to 25% of Total Workforce, Employee Competencies</span>
                                <span class="badge badge-warning">SGD$12.17/day Employer Levy</span>
                            </a>
                            <div class="header-elements">
                                <div class="list-icons">
                                    <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                    <a class="list-icons-item"><i class="icon-bin"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="header-elements-inline">
                            <a href="#" class="list-group-item" data-toggle="collapse">
                                Higher skilled – Monthly<br />
                                <span class="badge badge-primary badge-criteria">Criteria: Up to 25% of Total Workforce, Employee Competencies</span>
                                <span class="badge badge-warning">SGD$250/month Employer Levy</span>
                            </a>
                            <div class="header-elements">
                                <div class="list-icons">
                                    <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                    <a class="list-icons-item"><i class="icon-bin"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="header-elements-inline">
                            <a href="#" class="list-group-item" data-toggle="collapse">
                                Higher skilled – Daily<br />
                                <span class="badge badge-primary badge-criteria">Criteria: Up to 25% of Total Workforce, Employee Competencies</span>
                                <span class="badge badge-warning">SGD$8.22/day Employer Levy</span>
                            </a>
                            <div class="header-elements">
                                <div class="list-icons">
                                    <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                    <a class="list-icons-item"><i class="icon-bin"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="header-elements-inline">
                        <a href="#item-4-2-2" class="list-group-item" data-toggle="collapse">
                            <i class="glyphicon glyphicon-chevron-right"></i>Tier 2: Above 25% to 50% of the total workforce
                        </a>

                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                <a class="list-icons-item"><i class="icon-bin"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="list-group collapse" id="item-4-2-2">
                        <div class="header-elements-inline">
                            <a href="#" class="list-group-item" data-toggle="collapse">
                                Basic skilled – Monthly<br />
                                <span class="badge badge-primary badge-criteria">Criteria: 25% to 50% of Total Workforce, Employee Competencies</span>
                                <span class="badge badge-warning">SGD$470/month Employer Levy</span>
                            </a>
                            <div class="header-elements">
                                <div class="list-icons">
                                    <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                    <a class="list-icons-item"><i class="icon-bin"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="header-elements-inline">
                            <a href="#" class="list-group-item" data-toggle="collapse">
                                Basic skilled – Daily<br />
                                <span class="badge badge-primary badge-criteria">Criteria: 25% to 50% of Total Workforce, Employee Competencies</span>
                                <span class="badge badge-warning">SGD$15.46/day Employer Levy</span>
                            </a>
                            <div class="header-elements">
                                <div class="list-icons">
                                    <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                    <a class="list-icons-item"><i class="icon-bin"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="header-elements-inline">
                            <a href="#" class="list-group-item" data-toggle="collapse">
                                Higher skilled – Monthly<br />
                                <span class="badge badge-primary badge-criteria">Criteria: 25% to 50% of Total Workforce, Employee Competencies</span>
                                <span class="badge badge-warning">SGD$350/month Employer Levy</span>
                            </a>
                            <div class="header-elements">
                                <div class="list-icons">
                                    <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                    <a class="list-icons-item"><i class="icon-bin"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="header-elements-inline">
                            <a href="#" class="list-group-item" data-toggle="collapse">
                                Higher skilled – Daily<br />
                                <span class="badge badge-primary badge-criteria">Criteria: 25% to 50% of Total Workforce, Employee Competencies</span>
                                <span class="badge badge-warning">SGD$11.51/day Employer Levy</span>
                            </a>
                            <div class="header-elements">
                                <div class="list-icons">
                                    <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                    <a class="list-icons-item"><i class="icon-bin"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="header-elements-inline">
                        <a href="#item-4-2-3" class="list-group-item" data-toggle="collapse">
                            <i class="glyphicon glyphicon-chevron-right"></i>Tier 3: Above 50% to 60% of the total workforce
                        </a>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                <a class="list-icons-item"><i class="icon-bin"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="list-group collapse" id="item-4-2-3">
                        <div class="header-elements-inline">
                            <a href="#" class="list-group-item" data-toggle="collapse">
                                Basic skilled – Monthly<br />
                                <span class="badge badge-primary badge-criteria">Criteria: 50% to 60% of Total Workforce, Employee Competencies</span>
                                <span class="badge badge-warning">SGD$650/month Employer Levy</span>
                            </a>
                            <div class="header-elements">
                                <div class="list-icons">
                                    <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                    <a class="list-icons-item"><i class="icon-bin"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="header-elements-inline">
                            <a href="#" class="list-group-item" data-toggle="collapse">
                                Basic skilled – Daily<br />
                                <span class="badge badge-primary badge-criteria">Criteria: 50% to 60% of Total Workforce, Employee Competencies</span>
                                <span class="badge badge-warning">SGD$21.37/day Employer Levy</span>
                            </a>
                            <div class="header-elements">
                                <div class="list-icons">
                                    <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                    <a class="list-icons-item"><i class="icon-bin"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="header-elements-inline">
                            <a href="#" class="list-group-item" data-toggle="collapse">
                                Higher skilled – Monthly<br />
                                <span class="badge badge-primary badge-criteria">Criteria: 50% to 60% of Total Workforce, Employee Competencies</span>
                                <span class="badge badge-warning">SGD$550/month Employer Levy</span>
                            </a>
                            <div class="header-elements">
                                <div class="list-icons">
                                    <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                    <a class="list-icons-item"><i class="icon-bin"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="header-elements-inline">
                            <a href="#" class="list-group-item" data-toggle="collapse">
                                Higher skilled – Daily<br />
                                <span class="badge badge-primary badge-criteria">Criteria: 50% to 60% of Total Workforce, Employee Competencies</span>
                                <span class="badge badge-warning">SGD$18.09/day Employer Levy</span>
                            </a>
                            <div class="header-elements">
                                <div class="list-icons">
                                    <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                                    <a class="list-icons-item"><i class="icon-bin"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="header-elements-inline">
                    <a href="#item-4-3" class="list-group-item" data-toggle="collapse">
                        <i class="glyphicon glyphicon-chevron-right"></i>Marine shipyard
                    </a>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                            <a class="list-icons-item"><i class="icon-bin"></i></a>
                        </div>
                    </div>
                </div>

                <div class="header-elements-inline">
                    <a href="#item-4-4" class="list-group-item" data-toggle="collapse">
                        <i class="glyphicon glyphicon-chevron-right"></i>Process
                    </a>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                            <a class="list-icons-item"><i class="icon-bin"></i></a>
                        </div>
                    </div>
                </div>

                <div class="header-elements-inline">
                    <a href="#item-4-5" class="list-group-item" data-toggle="collapse">
                        <i class="glyphicon glyphicon-chevron-right"></i>Service
                    </a>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item"><i class="icon-pencil5"></i></a>
                            <a class="list-icons-item"><i class="icon-bin"></i></a>
                        </div>
                    </div>
                </div>

            </div>-->
        </div>
    </div>

</div>

<div id="modalTaxGroup" class="modal fade">
    <div class="modal-dialog modal-med">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title">Create New Tax Group</h6>
            </div>

            <div class="modal-body">
                <form id="saveTaxGroup" name="saveTaxGroup" method="post" action="">
                    <input type="hidden" id="tgID" name="tgID" value="0" />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Tax Group Title:</label>
                                <input type="text" name="groupTitle" id="groupTitle" class="form-control" value=""
                                       placeholder="Enter a title for this group" />
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description:</label>
                                <textarea name="groupDescription" id="groupDescription" rows="6" cols="5"
                                          placeholder="Description for this group (Optional)" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Parent:</label>
                                <select name="parent" id="parent" data-placeholder="" placeholder="" data-id=""
                                        class="form-control select select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Discard</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="modalTaxRule" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="saveTaxRule" name="saveTaxRule" method="post" action="">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title">Create New Tax Rule</h6>
            </div>

            <div class="modal-body">
                    <input type="hidden" id="trID" name="trID" value="0" />
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tax Rule Title: <span class="text-danger-400">*</span></label>
                                <input type="text" name="ruleTitle" id="ruleTitle" class="form-control" value=""
                                       placeholder="Enter a title for this tax rule" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Belong to Group:</label>
                                <select name="group" id="group" data-placeholder="" placeholder="" data-id=""
                                        class="form-control select select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Apply This Tax Rule To Which Office: <span class="text-danger-400">*</span></label>
                                <?TPL_OFFICE_LIST?>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Enter State (Optional):</label>
                                <select name="state" data-placeholder="Select State" placeholder="Select State" id="state" class="form-control select ">
                                    <option value="">Select State</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Enter City (Optional):</label>
                                <select name="city" data-placeholder="Select City" placeholder="Select City" id="city" class="form-control select ">
                                    <option value="">Select City</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <div class="card">
                                <div id="rulesWrapper" class="card-body" style="padding: 12px;">
                                </div>
                            </div>
                        </div>

                        <div id="criteriaTemplate" class="hide">
                            <div id="criteriaRow_{id}" class="col-md-3 criteriaRow criteriaFirstCol">
                                <div class="form-group">
                                    <label>Select Criteria: <span class="text-danger-400">*</span></label>
                                    <select name="criteria_{id}" id="criteria_{id}" data-placeholder="" placeholder="" data-id="{id}"
                                            class="form-control select select2-hidden-accessible criteria" tabindex="-1" aria-hidden="true">
                                        <option value=""></option>
                                        <optgroup label="Computing Variables">
                                            <option value="age">Age</option>
                                            <option value="payrollItem">Payroll Item</option>
                                            <option value="salary">Basic Salary</option>
                                            <option value="workforce">Total Workforce</option>
                                        </optgroup>

                                        <optgroup label="Other Employee Variables">
                                            <option value="competency">Competency</option>
                                            <option value="contract">Contract Type</option>
                                            <option value="designation">Designation</option>
                                            <option value="gender">Gender</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div id="computingTemplate" class="hide">
                            <div class="col-md-3">
                                <input type="hidden" id="tcID_{id}" name="tcID_{id}" value="" />
                                <div class="form-group">
                                    <label>Computing:</label>
                                    <select name="computing_{id}" id="computing_{id}" data-placeholder="" placeholder=""
                                            class="form-control select select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                        <option value="lt">Less Than</option>
                                        <option value="gt">Greater Than</option>
                                        <option value="lte">Less Than Or Equal</option>
                                        <option value="ltec">Less Than Or Equal And Capped At</option>
                                        <option value="gte">Greater Than Or Equal</option>
                                        <option value="eq">Equal</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Amount Type:</label>
                                    <select name="valueType_{id}" id="valueType_{id}" data-placeholder="" placeholder=""
                                            class="form-control select select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                        <option value="percentage">Percentage</option>
                                        <option value="fixed" selected>Fixed / Integer</option>
                                    </select>
                                </div>
                            </div>

                            <div id="col_{id}" class="col-md-2">
                                <div class="form-group">
                                    <label>Value:</label>
                                    <input type="number" class="form-control" id="value_{id}" name="value_{id}" placeholder="" />
                                </div>
                            </div>

                            <div class="col-md-1 criteriaLastCol">
                                <div class="form-group addCol">
                                    <a href="{id}" class="addCriteria"><i id="plus_{id}" class="icon-plus-circle2"></i></a>
                                </div>
                            </div>
                        </div>

                        <div id="payrollItemTemplate" class="hide">
                            <div id="col_{id}" class="col-md-8">
                                <input type="hidden" id="tpiID_{id}" name="tpiID_{id}" value="" />
                                <div class="form-group">
                                    <label>Select Payroll Item:</label>
                                    <?TPL_PAYROLL_ITEM_LIST?>
                                </div>
                            </div>

                            <div class="col-md-1 criteriaLastCol">
                                <div class="form-group addCol">
                                    <a href="{id}" class="addCriteria"><i id="plus_{id}" class="icon-plus-circle2"></i></a>
                                </div>
                            </div>
                        </div>

                        <div id="competencyTemplate" class="hide">
                            <div id="col_{id}" class="col-md-8">
                                <input type="hidden" id="cID_{id}" name="cID_{id}" value="" />
                                <div class="form-group">
                                    <label>Enter Competencies: <i class="icon-info22 mr-3" data-popup="tooltip" title="" data-html="true"
                                                                         data-original-title="<?LANG_COMPETENCY_INFO?>"></i>
                                        <span class="text-muted">(Type and press Enter to add new competency)</span></label>
                                    <input type="text" id="competency{template}" name="competency{template}" class="form-control tokenfield-typeahead"
                                           placeholder="Enter skillsets or knowledge"
                                           value="" autocomplete="off" data-fouc />
                                </div>
                            </div>

                            <div class="col-md-1 criteriaLastCol">
                                <div class="form-group addCol">
                                    <a href="{id}" class="addCriteria"><i id="plus_{id}" class="icon-plus-circle2"></i></a>
                                </div>
                            </div>
                        </div>

                        <div id="contractTemplate" class="hide">
                            <div id="col_{id}" class="col-md-8">
                                <input type="hidden" id="contractID_{id}" name="contractID_{id}" value="" />
                                <div class="form-group">
                                    <label>Select Contract Type:</label>
                                    <?TPL_CONTRACT_LIST?>
                                </div>
                            </div>

                            <div class="col-md-1 criteriaLastCol">
                                <div class="form-group addCol">
                                    <a href="{id}" class="addCriteria"><i id="plus_{id}" class="icon-plus-circle2"></i></a>
                                </div>
                            </div>
                        </div>

                        <div id="designationTemplate" class="hide">
                            <div id="col_{id}" class="col-md-8">
                                <input type="hidden" id="designationID_{id}" name="designationID_{id}" value="" />
                                <div class="form-group">
                                    <label>Select Designation:</label>
                                    <?TPL_DESIGNATION_LIST?>
                                </div>
                            </div>

                            <div class="col-md-1 criteriaLastCol">
                                <div class="form-group addCol">
                                    <a href="{id}" class="addCriteria"><i id="plus_{id}" class="icon-plus-circle2"></i></a>
                                </div>
                            </div>
                        </div>

                        <div id="genderTemplate" class="hide">
                            <div id="col_{id}" class="col-md-8">
                                <input type="hidden" id="genderID_{id}" name="genderID_{id}" value="" />
                                <div class="form-group">
                                    <label>Select Gender:</label>
                                    <div class="form-group p-8">
                                        <?TPL_GENDER_RADIO?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-1 criteriaLastCol">
                                <div class="form-group addCol">
                                    <a href="{id}" class="addCriteria"><i id="plus_{id}" class="icon-plus-circle2"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div style="width:100%; margin:15px 0 15px 0;"></div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Apply above criteria as:</label>
                                <select name="applyType" id="applyType" data-placeholder="" placeholder=""
                                        class="form-control select select2-hidden-accessible criteria" tabindex="-1" aria-hidden="true">
                                    <option value="salaryDeduction" selected>Deduction From Employee Salary</option>
                                    <option value="employerContribution">Employer Contribution</option>
                                    <option value="employerLevy">Employer Levy</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Type of Value:</label>
                                <select name="applyValueType" id="applyValueType" data-placeholder="" placeholder=""
                                        class="form-control select select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                    <option value="percentage">Percentage</option>
                                    <option value="fixed" selected>Fixed Amount / Integer</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Value: <span class="text-danger-400">*</span></label>
                                <input type="number" class="form-control" id="applyValue" name="applyValue" placeholder="" />
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <div class="modal-footer-btn">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Discard</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function( ) {
        $(".list-group-item").on("click", function() {
            $(".glyphicon", this).toggleClass("glyphicon-chevron-right")
                                 .toggleClass("glyphicon-chevron-down");
        });

        var data = {
            success: function (res) {
                var obj = $.parseJSON( res );
                $("#taxRulesWrapper").html( obj.html );

                $.each( $(".taxRow"), function( key, value ) {
                    var parent = $(this).attr("data-parent");

                    if( parent != 0 ) {
                        $("#expandIcon_" + parent).show( );
                        $(this).prependTo("#item-" + parent);
                    }
                });
            }
        };
        Aurora.WebService.AJAX("admin/payroll/getAll/html", data);

        function refreshGroupList( element ) {
            var data = {
                success: function (res) {
                    var res = $.parseJSON(res);

                    var data = $.map(res, function(obj) {
                        return {id: obj.id, text: obj.text, level: obj.level};
                    });

                    element.select2({
                        data: data,
                        formatSelection: function (item) {
                            return item.text
                        },
                        formatResult: function (item) {
                            return item.text
                        },
                        templateResult: formatResult,
                    });
                }
            };
            Aurora.WebService.AJAX("admin/payroll/getSelectList", data);
        }

        refreshGroupList( $("#parent") );
        refreshGroupList( $("#group") );

        function formatResult(node) {
            var $result = $('<span style="padding-left:' + (10 * node.level) + 'px;">' + node.text + '</span>');
            return $result;
        }

        $("#office").select2({minimumResultsForSearch:Infinity, allowClear:true});
        $("#state").select2( );
        $("#city").select2( );
        $("#applyType").select2({minimumResultsForSearch: Infinity});
        $("#applyValueType").select2({minimumResultsForSearch: Infinity});

        $(document).on("change", ".criteria", function(e) {
            $(".modal-footer .error").remove( );

            var id = $(this).attr("data-id");
            if( $("#criteriaSet_" + id).length > 0 ) {
                $("#criteriaSet_" + id).remove( );
            }

            if( $(this).val( ) == "age" ) {
                addComputing( $(this) );
            }
            if( $(this).val( ) == "payrollItem" ) {
                addPayrollItem( $(this) );
            }
            if( $(this).val( ) == "salary" ) {
                addComputing( $(this) );
            }
            if( $(this).val( ) == "workforce" ) {
                addComputing( $(this) );
            }
            if( $(this).val( ) == "competency" ) {
                addCompetency( $(this) );
            }
            if( $(this).val( ) == "contract" ) {
                addContract( $(this) );
            }
            if( $(this).val( ) == "designation" ) {
                addDesignation( $(this) );
            }
            if( $(this).val( ) == "gender" ) {
                addGender( $(this) );
            }
            var id = $("#rulesWrapper .criteriaRow").length-1;
            $("#criteriaRow_" + id).find(".addCriteria").show( );
        });

        function addCriteria( ) {
            var length = $("#rulesWrapper .criteriaRow").length;
            var criteria = $("#criteriaTemplate").html( );
            criteria = criteria.replace(/\{id\}/g, length );
            $("#rulesWrapper").append( '<div id="criteriaRowWrapper_' + length + '">' + criteria + "</div>" );
            $("#criteria_" + length).select2({minimumResultsForSearch: Infinity});

            var id = $("#rulesWrapper .criteriaRow").length-2;
            $("#plus_" + id).attr( "class", "icon-minus-circle2" );
            $("#plus_" + id).parent().attr( "class", "removeCriteria" );
        }

        addCriteria( );

        $(document).on( "click", ".addCriteria", function ( ) {
            addCriteria( );
            return false;
        });

        $(document).on( "click", ".removeCriteria", function ( ) {
            var id = $(this).attr("href");
            $("#criteriaRowWrapper_" + id).addClass("criteriaRow").html("").hide();
            return false;
        });

        function addPayrollItem( element ) {
            var id = element.attr("data-id");
            var html = $("#payrollItemTemplate").html( );
            html = html.replace(/\{id\}/g, id );
            $("#criteriaRow_" + id).after( '<div id="criteriaSet_' + id + '">' + html + '</div>' );
            $("#payrollItem_" + id).select2({minimumResultsForSearch:Infinity});
        }

        function addComputing( element ) {
            var id = element.attr("data-id");
            var html = $("#computingTemplate").html( );
            html = html.replace(/\{id\}/g, id );
            $("#criteriaRow_" + id).after( '<div id="criteriaSet_' + id + '">' + html + '</div>' );
            $("#computing_" + id).select2({minimumResultsForSearch:Infinity});
            $("#valueType_" + id).select2({minimumResultsForSearch:Infinity});
        }

        function addContract( element ) {
            var id = element.attr("data-id");
            var html = $("#contractTemplate").html( );
            html = html.replace(/\{id\}/g, id );
            html = html.replace(/\{template\}/g, "" );
            $("#criteriaRow_" + id).after( '<div id="criteriaSet_' + id + '">' + html + '</div>' );
            $("#contract_" + id).select2( );
        }

        function addDesignation( element ) {
            var id = element.attr("data-id");
            var html = $("#designationTemplate").html( );
            html = html.replace(/\{id\}/g, id );
            html = html.replace(/\{template\}/g, "" );
            $("#criteriaRow_" + id).after( '<div id="criteriaSet_' + id + '">' + html + '</div>' );
            $("#designation_" + id).select2( );
        }

        function addGender( element ) {
            if( $("#gender1").length > 0 ) {
                if( $(".modal-footer .error").length == 0 )
                    $(".modal-footer").prepend( '<label id="ruleTitle-error" class="error">You already have one Gender rule.</label>' );
                return false;
            }

            var id = element.attr("data-id");
            var html = $("#genderTemplate").html( );
            html = html.replace(/\{id\}/g, id );
            html = html.replace(/\{template\}/g, "" );
            $("#criteriaRow_" + id).after( '<div id="criteriaSet_' + id + '">' + html + '</div>' );
            $(".gender").uniform({radioClass: 'choice'});
        }

        function addCompetency( element ) {
            if( $("#competency").length > 0 ) {
                if( $(".modal-footer .error").length == 0 )
                    $(".modal-footer").prepend( '<label id="ruleTitle-error" class="error">You already have one Competency rule.</label>' );
                return false;
            }

            var id = element.attr("data-id");
            var html = $("#competencyTemplate").html( );
            html = html.replace(/\{id\}/g, id );
            html = html.replace(/\{template\}/g, "" );
            $("#criteriaRow_" + id).after( '<div id="criteriaSet_' + id + '">' + html + '</div>' );

            // Use Bloodhound engine
            var engine = new Bloodhound({
                remote: {
                    url: Aurora.ROOT_URL + 'admin/competency/getCompetency/%QUERY',
                    wildcard: '%QUERY',
                    filter: function (response) {
                        var tokens = $("#competency").tokenfield("getTokens");

                        return $.map( response, function( d ) {
                            var exists = false;
                            for( var i=0; i<tokens.length; i++ ) {
                                if( d.competency === tokens[i].label ) {
                                    exists = true;
                                    break;
                                }
                            }
                            if( !exists )
                                return { value: d.competency, id: d.cID }
                        });
                    }
                },
                datumTokenizer: function(d) {
                    return Bloodhound.tokenizers.whitespace(d.value);
                },
                queryTokenizer: Bloodhound.tokenizers.whitespace
            });

            // Initialize engine
            engine.initialize();

            // Initialize tokenfield
            $("#competency").tokenfield({
                delimiter: ';',
                typeahead: [null, {
                    displayKey: 'value',
                    highlight: true,
                    source: engine.ttAdapter()
                }]
            });
        }

        $("#modalTaxGroup").on("show.bs.modal", function(e) {
            var $invoker = $(e.relatedTarget);
            var tgID = $invoker.attr("data-id");

            if( tgID ) {
                var data = {
                    bundle: {
                        tgID: tgID
                    },
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if (obj.bool == 0) {
                            swal("error", obj.errMsg);
                            return;
                        }
                        else {
                            $("#tgID").val( obj.data.tgID );
                            $("#groupTitle").val( obj.data.title );
                            $("#groupDescription").val( obj.data.description );
                            $("#parent").val( obj.data.parent ).trigger("change");
                        }
                    }
                }
                Aurora.WebService.AJAX( "admin/payroll/getTaxGroup/" + tgID, data );
            }
            else {
                $("#tgID").val(0);
                $("#groupTitle").val("");
                $("#groupDescription").val("");
                $("#parent").val(0).trigger("change");
            }
        });

        $("#saveTaxGroup").validate({
            rules: {
                groupTitle: { required: true }
            },
            messages: {
                groupTitle: "Please enter a Group Title."
            },
            submitHandler: function( ) {
                var tgID = $("#tgID").val( );

                var data = {
                    bundle: {
                        tgID: tgID,
                        groupTitle: $("#groupTitle").val( ),
                        groupDescription: $("#groupDescription").val( ),
                        parent: $("#parent").val( )
                    },
                    success: function( res ) {
                        var obj = $.parseJSON( res );
                        if( obj.bool == 0 ) {
                            swal("error", obj.errMsg);
                            return;
                        }
                        else {
                            refreshGroupList($("#parent"));
                            refreshGroupList($("#group"));

                            if( tgID != 0 ) {
                                $("#groupTitle_" + tgID).html( obj.data.title );
                                $("#groupDescription_" + tgID).html( obj.data.description );
                                $("#group_" + tgID).appendTo( $("#item-" + obj.data.parent) );
                                swal("Done!", obj.data.title + " has been successfully updated!", "success");
                            }
                            else {
                                var data = {
                                    success: function(res) {
                                        var obj2 = $.parseJSON(res);
                                        if( obj2.bool == 0 ) {
                                            swal( "error", obj2.errMsg );
                                            return;
                                        }
                                        if( obj.data.parent == 0 ) {
                                            $(".list-group-root").append( obj2.html );
                                        }
                                        else {
                                            $("#item-" + obj.data.parent).append( obj2.html );
                                            $("#expandIcon_" + obj.data.parent).show( );
                                        }
                                        $(".blankCanvasNotice").hide( );

                                        swal({
                                            title: obj.data.title + " has been successfully created!",
                                            text: "What do you want to do next?",
                                            type: 'success',
                                            confirmButtonClass: 'btn btn-success',
                                            cancelButtonClass: 'btn btn-danger',
                                            buttonsStyling: false,
                                            showCancelButton: true,
                                            confirmButtonText: "Create Another Tax Group",
                                            cancelButtonText: "Close Window",
                                            reverseButtons: true
                                        }, function (isConfirm) {
                                            if( isConfirm === false ) {
                                                $("#modalTaxGroup").modal('hide');
                                            }
                                            else {
                                                $("#groupTitle").focus( );
                                            }
                                        });
                                    }
                                }
                                Aurora.WebService.AJAX("admin/payroll/getTaxGroup/" + obj.data.tgID, data);
                            }
                        }
                    }
                };
                Aurora.WebService.AJAX( "admin/payroll/saveTaxGroup", data );
            }
        });


        $("#modalTaxRule").on("show.bs.modal", function(e) {
            if( $("#gender1").length > 0 ) {
                $.uniform.restore(".gender");
            }
            $("#rulesWrapper").html("");
            addCriteria( );

            var $invoker = $(e.relatedTarget);
            var trID = $invoker.attr("data-id");

            if( trID ) {
                var data = {
                    bundle: {
                        trID: trID
                    },
                    success: function(res) {
                        var obj = $.parseJSON(res);
                        if( obj.bool == 0 ) {
                            swal("error", obj.errMsg);
                            return;
                        }
                        else {
                            $("#trID").val( obj.data.trID );
                            $("#ruleTitle").val( obj.data.title );
                            $("#group").val( obj.data.tgID ).trigger("change");
                            $("#office").val( obj.data.officeID ).trigger("change");
                            $("#city").val( obj.data.city ).trigger("change");
                            $("#state").val( obj.data.state ).trigger("change");
                            $("#applyType").val( obj.data.applyType ).trigger("change");
                            $("#applyValueType").val( obj.data.applyValueType ).trigger("change");
                            $("#applyValue").val( obj.data.applyValue );

                            var criteria=0;

                            if( obj.data.computing ) {
                                for( var i=0; i<obj.data.computing.length; i++ ) {
                                    if( criteria > 0 ) {
                                        addCriteria( );
                                    }
                                    $("#criteria_" + criteria).val( obj.data.computing[i]["criteria"] ).trigger("change");
                                    $("#tcID_" + criteria).val( obj.data.computing[i]["tcID"] );
                                    $("#computing_" + criteria).val( obj.data.computing[i]["computing"] ).trigger("change");
                                    $("#valueType_" + criteria).val( obj.data.computing[i]["valueType"] ).trigger("change");
                                    $("#value_" + criteria).val( obj.data.computing[i]["value"] );
                                    criteria++;
                                }
                            }

                            if( obj.data.competency && obj.data.competency.length > 0 ) {
                                if( criteria > 0 ) {
                                    addCriteria( );
                                }
                                $("#criteria_" + criteria).val("competency").trigger("change");

                                var competency = "";
                                for( var i=0; i<obj.data.competency.length; i++ ) {
                                    competency += obj.data.competency[i]["competency"] + ";";
                                }
                                $("#competency").val( competency ).trigger('change');
                                criteria++;
                            }

                            if( obj.data.contract && obj.data.contract.length > 0 ) {
                                for( var i=0; i<obj.data.contract.length; i++ ) {
                                    if( criteria > 0 ) {
                                        addCriteria( );
                                    }
                                    $("#criteria_" + criteria).val("contract").trigger("change");
                                    $("#contractID_" + criteria).val( obj.data.contract[i]["tcID"] );
                                    $("#contract_" + criteria).val( obj.data.contract[i]["contract"] ).trigger('change');
                                    criteria++;
                                }
                            }

                            if( obj.data.designation && obj.data.designation.length > 0 ) {
                                for( var i=0; i<obj.data.designation.length; i++ ) {
                                    if( criteria > 0 ) {
                                        addCriteria( );
                                    }
                                    $("#criteria_" + criteria).val("designation").trigger("change");
                                    $("#designationID_" + criteria).val( obj.data.designation[i]["tdID"] );
                                    $("#designation_" + criteria).val( obj.data.designation[i]["designation"] ).trigger('change');
                                    criteria++;
                                }
                            }

                            if( obj.data.gender && obj.data.gender.length > 0 ) {
                                if( criteria > 0 ) {
                                    addCriteria( );
                                }
                                $("#criteria_" + criteria).val("gender").trigger("change");
                                $("input[name=gender][value=" + obj.data.gender[0]["gender"] + "]").prop('checked', true);
                                $.uniform.update("input[name=gender]");
                            }

                            if( criteria > 0 ) {
                                addCriteria( );
                            }
                        }
                    }
                }
                Aurora.WebService.AJAX( "admin/payroll/getTaxRule/" + trID, data );
            }
            else {
                $("#trID").val(0);
                $("#ruleTitle").val("");
                $("#group").val(0).trigger("change");
                $("#office").val("").trigger("change");
                $("#city").val("").trigger("change");
                $("#state").val("").trigger("change");
                $("#applyType").val("salaryDeduction").trigger("change");
                $("#applyValueType").val("percentage").trigger("change");
                $("#applyValue").val("");
            }
        });

        $("#saveTaxRule").validate({
            rules: {
                ruleTitle: { required: true }
            },
            messages: {
                ruleTitle: "Please enter a Rule Title."
            },
            highlight: function(element, errorClass) {
                $(element).addClass("border-danger");
            },
            unhighlight: function(element, errorClass) {
                $(element).removeClass("border-danger");
                $(".modal-footer .error").remove();
            },
            // Different components require proper error label placement
            errorPlacement: function(error, element) {
                if( $(".modal-footer .error").length == 0 )
                    $(".modal-footer").prepend(error);
            },
            submitHandler: function( ) {
                var count = $(".criteria").length;
                var found = false;

                for( var i=0; i<count; i++ ) {
                    if( $("#criteria_" + i).val( ) ) {
                        found = true;
                        break;
                    }
                }
                if( !found ) {
                    $(".modal-footer").prepend( '<label id="ruleTitle-error" class="error">Please provide at least one set of criteria.</label>' );
                }
                else {
                    var formData = Aurora.WebService.serializePost("#saveTaxRule");

                    var data = {
                        bundle: {
                            data: formData
                        },
                        success: function( res ) {
                            var obj = $.parseJSON( res );
                            if( obj.bool == 0 ) {
                                swal("error", obj.errMsg);
                                return;
                            }
                            else {
                                var data = {
                                    success: function( res ) {
                                        var obj2 = $.parseJSON( res );
                                        if( obj2.bool == 0 ) {
                                            swal("error", obj2.errMsg);
                                            return;
                                        }
                                        if( $("#trID").val( ) > 0 ) {
                                            $("#taxRow_" + $("#trID").val( )).replaceWith( obj2.html );
                                        }
                                        else {
                                            if( obj.data.group == 0 ) {
                                                $(".list-group-root").append( obj2.html );
                                            }
                                            else {
                                                $("#item-" + obj.data.group).append( obj2.html );
                                                $("#expandIcon_" + obj.data.group).show( );
                                            }
                                            $(".blankCanvasNotice").hide( );
                                        }

                                        swal({
                                            title: $("#ruleTitle").val( ) + " has been successfully created!",
                                            text: "What do you want to do next?",
                                            type: 'success',
                                            confirmButtonClass: 'btn btn-success',
                                            cancelButtonClass: 'btn btn-danger',
                                            buttonsStyling: false,
                                            showCancelButton: true,
                                            confirmButtonText: "Create Another Tax Rule",
                                            cancelButtonText: "Close Window",
                                            reverseButtons: true
                                        }, function( isConfirm ) {
                                            if( isConfirm === false ) {
                                                $("#modalTaxRule").modal('hide');
                                            }
                                            else {
                                                $("#ruleTitle").focus( );
                                            }
                                        });
                                    }
                                }
                                Aurora.WebService.AJAX( "admin/payroll/getTaxRule/" + obj.data.trID + "/html", data );
                            }
                        }
                    };
                    Aurora.WebService.AJAX( "admin/payroll/saveTaxRule", data );
                }
            }
        });
    });
</script>