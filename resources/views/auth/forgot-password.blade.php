<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Lupa Password - Sistem Absensi KKM</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Icon -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">


<style>

*{
    font-family:'Poppins',sans-serif;
}

body{
    margin:0;
    background:#F8FAFC;
}


/* Layout */
.auth-wrapper{
    min-height:100vh;
    display:flex;
}


/* LEFT */
.auth-left{
    width:55%;
    background:linear-gradient(
        135deg,
        #2563EB,
        #1D4ED8,
        #1E3A8A
    );

    color:white;
    padding:5rem;

    display:flex;
    align-items:center;

    position:relative;
    overflow:hidden;
}


.auth-left::before{

    content:"";
    position:absolute;

    width:400px;
    height:400px;

    background:rgba(255,255,255,.08);

    border-radius:50%;

    top:-120px;
    right:-120px;

}


.left-content{
    position:relative;
    z-index:2;
}


.icon-large{

    width:110px;
    height:110px;

    border-radius:30px;

    background:rgba(255,255,255,.15);

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:55px;

    margin-bottom:35px;

}


.title{

    font-size:48px;
    font-weight:700;

}


.subtitle{

    font-size:18px;
    opacity:.85;

    max-width:550px;
    margin-top:20px;

}


.feature{

    margin-top:50px;

}


.feature div{

    margin-bottom:18px;
    font-size:18px;

}


.feature i{

    color:#93C5FD;
    margin-right:12px;

}




/* RIGHT */
.auth-right{

    width:45%;

    background:white;

    display:flex;
    justify-content:center;
    align-items:center;

    padding:50px;

}


.card-box{

    width:100%;
    max-width:430px;

}



.logo{

    width:65px;
    height:65px;

    background:#DBEAFE;

    border-radius:20px;

    display:flex;
    align-items:center;
    justify-content:center;

    color:#2563EB;
    font-size:35px;

    margin-bottom:25px;

}



h2{

    font-weight:700;
    color:#0F172A;

}


.desc{

    color:#64748B;
    margin-top:15px;

}


.contact-box{

    background:#EFF6FF;

    border-radius:16px;

    padding:25px;

    margin-top:30px;

    border:1px solid #BFDBFE;

}



.contact-item{

    display:flex;
    align-items:center;

    margin-bottom:18px;

    color:#334155;

}


.contact-item:last-child{

    margin-bottom:0;

}


.contact-item i{

    font-size:22px;
    color:#2563EB;

    margin-right:15px;

}



.btn-back{

    background:#2563EB;

    color:white;

    border-radius:14px;

    padding:14px;

    font-weight:600;

    text-decoration:none;

    display:block;

    text-align:center;

    margin-top:35px;

    transition:.3s;

}



.btn-back:hover{

    background:#1D4ED8;
    color:white;

    transform:translateY(-2px);

}




@media(max-width:992px){

    .auth-left{
        display:none;
    }

    .auth-right{
        width:100%;
    }

}

</style>


</head>


<body>


<div class="auth-wrapper">


    <!-- LEFT -->
    <div class="auth-left">

        <div class="left-content">


            <div class="icon-large">

                <i class="bi bi-shield-lock"></i>

            </div>


            <h1 class="title">
                Keamanan Akun
            </h1>


            <p class="subtitle">

                Sistem reset password dikelola langsung oleh pengurus untuk menjaga keamanan akun anggota KKM.

            </p>



            <div class="feature">


                <div>
                    <i class="bi bi-check-circle-fill"></i>
                    Verifikasi oleh Administrator
                </div>


                <div>
                    <i class="bi bi-check-circle-fill"></i>
                    Data akun tetap aman
                </div>


                <div>
                    <i class="bi bi-check-circle-fill"></i>
                    Reset password lebih cepat
                </div>


            </div>



        </div>


    </div>





    <!-- RIGHT -->
    <div class="auth-right">


        <div class="card-box">


            <div class="logo">

                <i class="bi bi-person-lock"></i>

            </div>



            <h2>
                Lupa Password?
            </h2>



            <p class="desc">

                Apabila Anda lupa password, silakan hubungi pengurus KKM untuk melakukan perubahan password akun.

            </p>




            <div class="contact-box">


                <div class="contact-item">

                    <i class="bi bi-person-badge"></i>

                    Ketua KKM

                </div>



                <div class="contact-item">

                    <i class="bi bi-person-check"></i>

                    Sekretaris KKM

                </div>



                <div class="contact-item">

                    <i class="bi bi-person-gear"></i>

                    Administrator Sistem

                </div>


            </div>





            <a href="{{ route('login') }}" class="btn-back">

                <i class="bi bi-arrow-left me-2"></i>

                Kembali Login

            </a>



        </div>


    </div>



</div>


</body>

</html>