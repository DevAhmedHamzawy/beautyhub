 <section class="product brand" data-aos="fade-up">
     <div class="container">
         <div class="section-title">
             <h5>Brand of Prodcuts</h5>
             <a href="product-sidebar.html" class="view">View All</a>
         </div>
         <div class="brand-section">

             @foreach ($brands as $brand)
                 <div class="product-wrapper">
                     <div class="wrapper-img">
                         <a href="product-sidebar.html">
                             <img src="{{ asset($brand->img_path) }}" alt="img" />
                         </a>
                     </div>
                 </div>
             @endforeach

         </div>
     </div>
 </section>
