<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ragil Cell - Contact Us</title>
    
    <link rel="shortcut icon" type="image/x-icon" href="image/CEL.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" >
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="responif.css">

</head>
<style>
/* CONTACT */

#contact-header {
  margin-top: 100px;
}

#contact-details{
  display: flex;
  align-items: center;
  justify-content: space-between;
}

#contact-details .details{
  width: 40%;
}

#contact-details .details span,
#form-details form span{
  font-size: 12px;
}

#contact-details .details h2,
#form-details form h2{
  font-size: 26px;
  line-height: 35px;
  padding: 20px 0;
}

#contact-details .details h3{
  font-size: 16px;
  font-weight: 600;
  padding-bottom: 15px;
}

#contact-details .details li{
  list-style: none;
  display: flex;
  padding: 10px 0;
}

#contact-details .details li i{
  font-size: 14px;
  padding-right: 22px;
}

#contact-details .details li p{
  margin: 0;
  font-size: 14px;
}

#contact-details .map{
  width: 55%;
  height: 400px;
}

#contact-details .map iframe{
  width: 100%;
  height: 100%;
}

                                                                                /* FORM */
#form-details{
    display: flex;
    justify-content: space-between;
    margin-top: 50px;
    padding: 80px;
    border: 1px solid #e1e1e1;
}

#form-details form{
    width: 65%;
    display: flex;
    flex-direction: column;
    align-items: flex-start;    
}

#form-details form input,
#form-details form textarea{
    width: 100%;
    padding: 12px 15px;
    outline: none;
    margin-bottom: 20px;
    border: 1px solid #e1e1e1;
}

#form-details form button{
    opacity: 1;
    transition: 0.3s all;
    margin-right: 10px;
    outline: none;
}

#form-details .people div{
    padding-bottom: 25px;
    display: flex;
    align-items: flex-start;
}

#form-details .people div img{
    width: 65px;
    height: 65px;
    object-fit: cover;
    margin-right: 15px;
}

#form-details .people div p{
    margin: 0;
    font-size: 13px;
    line-height: 25px;
}

#form-details .people div p span{
    display: block;
    font-size: 16px;
    font-weight: 600;
    color: #0a0a0a;
}

</style>

<body>
   <!-- NAVIGATION -->
    <nav class="navbar navbar-expand-lg navbar-light py-3 fixed-top">
      <div class="container">
          <img src="image/CEL.png" style="width: 55px;" alt="">
          <a class="navbar-brand ml-3" href="#" style="font-weight: bold;">ragilcell.</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span><i id="bar" class="fa-solid fa-bars"></i></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav ml-auto">
                  <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                  <li class="nav-item"><a class="nav-link" href="shop.php">Shop</a></li>
                  <li class="nav-item"><a class="nav-link" href="blog.php">Blog</a></li>
                  <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                  <li class="nav-item"><a class="nav-link active" href="contact.php">Contact Us</a></li>
                  <li class="nav-item">
                      <a href="cart.php"><i class="fa-solid fa-bag-shopping"></i></a>
                      <a href="profile.php"><i class="fa-solid fa-user"></i></a>
                  </li>
              </ul>
          </div>
      </div>
    </nav>

      <!-- our product -->
    <section id="contact-header" class="container mb-5 pt-5">
      <div class="about-header text-center">
        <h2 class="font-weight-bold">Contact Us</h2>
        <p>Stay connected with us for all your mobile needs.</p>
      </div>
    </section>
      
         <!-- contact -->
    <section id="contact-details" class="container">
        <div class="details">
            <span>GET IN TOUCH</span>
            <h2>Visit our agency location or contact us today</h2>
            <h3>Head Office</h3>
            <div>
                <li>
                    <i class="fa-solid fa-map"></i>
                    <p>Jl. Jenderal Basuki Rahmat No 2A Kiduldalem, Kec. Klojen Kota Malang (Mall Sarinah)</p>
                </li>
                <li>
                    <i class="fa-solid fa-envelope"></i>
                    <p>ragilcell86@gmail.com</p>
                </li>
                <li>
                    <i class="fa-solid fa-phone-alt"></i>
                    <p>+6281230344825</p>
                </li>
                <li>
                    <i class="fa-solid fa-clock"></i>
                    <p>Monday to Saturday: 10.00am to 20.00pm</p>
                </li>
            </div>
        </div>
        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3951.1697421952326!2d112.62806887412377!3d-7.981399179579115!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd6282367886747%3A0xcde3935a14c23e2f!2sMall%20Sarinah%20Malang!5e0!3m2!1sid!2sid!4v1723472487171!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>

    <!-- form -->
     <section id="form-details" class="container">
        <form action="">
            <span>LEAVE A MESSAGE</span>
            <h2>We love to hear from you</h2>
            <input type="text" placeholder="Your Name">
            <input type="text" placeholder="Email">
            <input type="text" placeholder="Number">
            <input type="text" placeholder="Subject">
            <textarea name="" id="" cols="30" rows="10" placeholder="Your Message"></textarea>
            <button class="normal">Submit</button>
        </form>

        <div class="people">
            <div>
                <img src="image/claim.png" alt="">
                <p><span>Akh. Yusuf Effendi</span> Marketing Manager <br>Phone :08123456789 <br>Email : yusufeffendi@gmail.com</p>
            </div>
            <div>
                <img src="image/claim.png" alt="">
                <p><span>Nova Dwi Nurul A.</span> Marketing Manager<br>Phone :08123456789 <br>Email : novadwi@gmail.com</p>
            </div>
        </div>
     </section>


    <!-- FOOTER -->
    <footer class="mt-5 py-5">
    <div class="row container mx-auto pt-5">
      <div class="footer-one col-lg-3 col-md-6 col-12">
        <img src="image/CEL.png" style="width: 55px;" alt="ragilcell.">
        <p class="pt-3">ragilcell offers a wide range of new and used mobile phones from top brands at competitive prices. Enjoy easy, safe, and convenient shopping with us.</p>
      </div>
  
      <div class="footer-one col-lg-3 col-md-6 col-12 mb-3">
        <h5 class="pb-2">My Account</h5>
        <ul class="text-uppercase list-unstyled">
          <li><a href="#">Sign in</a></li>
          <li><a href="#">View Cart</a></li>
          <li><a href="#">Track My Order</a></li>
          <li><a href="#">Help</a></li>
        </ul>
      </div>   
  
      <div class="footer-one col-lg-3 col-md-6 col-12 mb-3">
        <h5 class="pb-2">About</h5>
        <ul class="text-uppercase list-unstyled">
          <li><a href="home.php">Home</a></li>
          <li><a href="about.php">About Us</a></li>
          <li><a href="contact.php">Contact Us</a></li>
        </ul>
      </div>
  
      <div class="footer-one col-lg-3 col-md-6 col-12 mb-3">
        <h5 class="pb-2">Contact Us</h5>
        <div>
          <h6 class="text-uppercase">Address</h6>
          <p>MALL Sarinah Malang</p>
        </div>
        <div>
          <h6 class="text-uppercase">Phone</h6>
          <p>+6281230344825</p>
        </div>
        <div>
          <h6 class="text-uppercase">Email</h6>
          <p>ragilcell87@gmail.com</p>
        </div>
      </div>
    </div>

    <div class="copyright mt-5">
      <div class="row container mx-auto">

        <div class="col-lg-5 col-md-6 col-12 mb-4">
          <img src="image/bank/bank.png" alt="Mandiri">
        </div>
        <div class="col-lg-5 col-md-6 col-6 text-nowrap mb-2">
          <p>@2024.ragilcell. All rights reserved.</p>
        </div>
        <div class="col-lg-2 col-md-6 col-12">
          <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
          <a href="#"><i class="fa-brands fa-twitter"></i></a>
          <a href="#"><i class="fa-brands fa-instagram"></i></a>
        </div>
      </div>
    </div>
  </footer>
  
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>
</html>
