@extends('layouts.default')


@section('content')

  <div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->


  <section class="section dashboard">
    <div class="row">

      <!-- Left side columns -->
      <div class="col-lg-8">
        <div class="row">


          <!-- Revenue Card -->
          <div class="col-xxl-6 col-md-6">
            <div class="card info-card revenue-card">

              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filtro</h6>
                  </li>

                  <li><a class="dropdown-item" href="#">Hoje</a></li>
                  <li><a class="dropdown-item" href="#">Esta Semana</a></li>
                  <li><a class="dropdown-item" href="#">Este mês</a></li>
                </ul>
              </div>

              <div class="card-body">
                <h5 class="card-title">Contas a pagar <span>| Hoje</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-currency-dollar"></i>
                  </div>
                  <div class="ps-3">
                    <h6>35</h6>
                    <span class="text-danger small pt-1 fw-bold">(TOTAL)</span> <span class="text-muted small pt-2 ps-1">R$ 10530.20</span>

                  </div>
                </div>
              </div>

            </div>
          </div><!-- End Revenue Card -->

          <!-- Sales Card -->
          <div class="col-xxl-6 col-md-6">

            <div class="card info-card sales-card">

              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filtro</h6>
                  </li>

                  <li><a class="dropdown-item" href="#">Hoje</a></li>
                  <li><a class="dropdown-item" href="#">Esta Semana</a></li>
                  <li><a class="dropdown-item" href="#">Este mês</a></li>
                </ul>
              </div>

              <div class="card-body">
                <h5 class="card-title">Pedidos <span>| Hoje</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-cart"></i>
                  </div>
                  <div class="ps-3">
                    <h6>145</h6>
                    <span class="text-success small pt-1 fw-bold">(TOTAL)</span> <span class="text-muted small pt-2 ps-1">R$ 35195.20</span>

                  </div>
                </div>
              </div>

            </div>
          </div><!-- End Sales Card -->


          <!-- Recent Sales -->
          <div class="col-12">
            <div class="card recent-sales overflow-auto">

              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                  </li>

                  <li><a class="dropdown-item" href="#">Hoje</a></li>
                  <li><a class="dropdown-item" href="#">Esta semana</a></li>
                  <li><a class="dropdown-item" href="#">Este mês</a></li>
                </ul>
              </div>

              <div class="card-body">
                <h5 class="card-title">Pedidos recentes <span>| Hoje</span></h5>

                <table class="table table-borderless datatable">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Fornecedor</th>
                      <th scope="col">Produtos</th>
                      <th scope="col">Valor</th>
                      <th scope="col">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th scope="row"><a href="#">#2457</a></th>
                      <td>Brandon Jacob</td>
                      <td><a href="#" class="text-primary">At praesentium minu</a></td>
                      <td>$64</td>
                      <td><span class="badge bg-success">Aprovado</span></td>
                    </tr>
                    <tr>
                      <th scope="row"><a href="#">#2147</a></th>
                      <td>Bridie Kessler</td>
                      <td><a href="#" class="text-primary">Blanditiis dolor omnis similique</a></td>
                      <td>$47</td>
                      <td><span class="badge bg-warning">Pendente</span></td>
                    </tr>
                    <tr>
                      <th scope="row"><a href="#">#2049</a></th>
                      <td>Ashleigh Langosh</td>
                      <td><a href="#" class="text-primary">At recusandae consectetur</a></td>
                      <td>$147</td>
                      <td><span class="badge bg-success">Aprovado</span></td>
                    </tr>
                    <tr>
                      <th scope="row"><a href="#">#2644</a></th>
                      <td>Angus Grady</td>
                      <td><a href="#" class="text-primar">Ut voluptatem id earum et</a></td>
                      <td>$67</td>
                      <td><span class="badge bg-danger">Rejeitado</span></td>
                    </tr>
                    <tr>
                      <th scope="row"><a href="#">#2644</a></th>
                      <td>Raheem Lehner</td>
                      <td><a href="#" class="text-primary">Sunt similique distinctio</a></td>
                      <td>$165</td>
                      <td><span class="badge bg-success">Aprovado</span></td>
                    </tr>
                  </tbody>
                </table>

              </div>

            </div>
          </div><!-- End Recent Sales -->
         

        

        

          

       

        </div>
      </div><!-- End Left side columns -->

      <!-- Right side columns -->
      <div class="col-lg-4">



        <!-- Website Traffic -->
        <div class="card">
          <div class="filter">
            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
              <li class="dropdown-header text-start">
                <h6>Filter</h6>
              </li>

              <li><a class="dropdown-item" href="#">Hoje</a></li>
              <li><a class="dropdown-item" href="#">Esta semana</a></li>
              <li><a class="dropdown-item" href="#">Este mês</a></li>
            </ul>
          </div>

          <div class="card-body pb-0">
            <h5 class="card-title">Visão geral<span>| Hoje</span></h5>

            <div id="trafficChart" style="min-height: 400px;" class="echart"></div>

            <script>
              document.addEventListener("DOMContentLoaded", () => {
                echarts.init(document.querySelector("#trafficChart")).setOption({
                  tooltip: {
                    trigger: 'item'
                  },
                  legend: {
                    top: '5%',
                    left: 'center'
                  },
                  series: [{
                    name: 'Access From',
                    type: 'pie',
                    radius: ['40%', '70%'],
                    avoidLabelOverlap: false,
                    label: {
                      show: false,
                      position: 'center'
                    },
                    emphasis: {
                      label: {
                        show: true,
                        fontSize: '18',
                        fontWeight: 'bold'
                      }
                    },
                    labelLine: {
                      show: false
                    },
                    data: [{
                        value: 1048,
                        name: 'Fornecedores'
                      },
                      {
                        value: 735,
                        name: 'Produtos'
                      },
                      {
                        value: 580,
                        name: 'Pedidos'
                      },
                    //   {
                    //     value: 484,
                    //     name: 'Union Ads'
                    //   },
                    //   {
                    //     value: 300,
                    //     name: 'Video Ads'
                    //   }
                    ]
                  }]
                });
              });
            </script>

          </div>
        </div><!-- End Website Traffic -->


      </div><!-- End Right side columns -->

    </div>
  </section>

@endsection