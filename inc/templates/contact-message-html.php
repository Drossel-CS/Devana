<!DOCTYPE html>
    <html>
        <head>
            <!-- General styles, not used by all email clients -->
            <style type="text/css" media="all">
            @import url('https://fonts.googleapis.com/css?family=Montserrat:400,600');
                body{
                    background: #fff;
                    font-family: 'Montserrat', sans-serif;
                }
                .wrapp{
                    max-width: 800px;
                    padding: 30px;
                    margin: 0 auto;
                }
                .center{
                    text-align:center;
                }
                .text{
                    line-height: 1.5;
                    text-indent: 20px;
                    text-align: justify;
                }
                    .text-content{
                        background: #FAFAFA;
                        border-radius: 20px;
                        padding: 20px;
                    }
                header img{
                    width: 30%;
                }

                .footer-sub-text{
                    font-size: .8em;
                    color: #ACACAC;
                }
                    .sig{
                        margin-top: 40px;
                        color: #DDDDDD;
                        font-size: .8em;
                        letter-spacing: 5px;
                    }
                a {
                    text-decoration: none;
                    color: #0088cc;
                }
                hr {
                    border-top: 1px solid #999;
                }
            </style>
        </head>
    
        <!-- KEEP THE LAYOUT SIMPLE: THOSE ARE SERVICE MESSAGES. -->
        <body>
                <header>
                    <div class="wrapp">
                        <img src="<?php echo $image[0]; ?>">
                    </div>
                
                </header>
                <main class="wrapp">
                    <div class="">
                        <p>Ahoj Lenka, <b><?php echo $title;?></b> ti zasiela nasledovnú správu</p>
                        <p class="text text-content"><i><?php echo $message; ?></i></p>
                    </div>
                </main>
                <footer>
                    <div class="wrapp">
                        <p class="center footer-sub-text">Táto správa bola automaticky generovaná systémom DMS® | www.drossel.sk</p>
                        <p class="center sig">DROSSEL | CREATIVE STUDIO</p>
                    </div>
                </footer>
    
            <!-- Main table 100% wide with background color #eee -->    
           
                                    <p><?php 
                                            echo $title;
                                            if($phone != ''){
                                                echo ' ,'.$phone;
                                            }
                                        ?>
                                    </p>
                                    