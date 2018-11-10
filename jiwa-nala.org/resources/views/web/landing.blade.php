<?php

require_once('index_function.php'); 

save();

?>
<!DOCTYPE html>
<html lang="id" lang-fallback="en" app-version="0.1a" userid="<?php echo getUserID(); ?>" device="<?php echo getDevice(); ?>">
	<!-- begin::Head -->    
	<head>        
		<meta charset="utf-8" />
		<meta name="description" content="YAYASAN JIWA NALA, sekolah islam fullday (TK, SD, SMP) terbaik di surabaya" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" />
		<meta name="author" content="akhmad musa hadi" />
		<meta name="author.email" content="akhmad.musa.hadi@gmail.com" />
		<meta name="keywords" content="jiwanala, jiwa nala, foundation, yayasan jiwanala, sekolah fullday, sekolah fullday terbaik di surabaya" />
		<meta name="google-site-verification" content="4YYp5IOSkVsk-QbsEZMT1hH0d2Gqd39Q37N89jeinLY" />
		<title>YAYASAN JIWANALA - Sekolah islam di Surabaya. (TK, SD, & SMP)</title>        
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
			WebFont.load({
				google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600"]},
				active: function() {                
					sessionStorage.fonts = true;            
				}
			});
		</script>
		<script src="https://momentjs.com/downloads/moment.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
		
		<!-- Global Site Tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-128637514-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-128637514-1');
        </script>
        
		<style>
			html, body { font-family: Roboto; background-color:#1b1b1a; color:#fefefe; margin:0; padding:0;}
			h1, h2, h3, h4, p, div {margin:0;}
			a {text-decoration:none; color:#3582c3;}
			
			.hide {display:none;}
			
			content .wrapper-center {position: relative; text-align:center}
			content>.slide {padding: 4em 0;}
			
			content>div.slide h2.title {font-weight: 500; letter-spacing: .05em;}
			content>div.slide p.info {font-weight: 100; font-size:1.25em; margin:.5em 0 .5em 0;}
			
			content>div#slide1 .brand .brand-name {font-family: Poppins; position:relative; top:-.2em; letter-spacing: .05em; font-size: 1.75em;}
			content>div#slide1 .brand .brand-sub {font-weight: 300; position:relative; top:-.5em; letter-spacing: .05em; font-size: 1em;}
			content>div#slide1 .brand img.brand {width: 7em; padding: 0;margin: 0;}
			content>div#slide1 .box-item {display: inline-block; margin:.75em; width: 7em;height: 7em; background-color: #3582c3;}
			content>div#slide1 .box-item span {position: relative;top:.5em;font-family:Poppins; font-size:1.25em;display: block; margin:.8em auto 0 auto;}
			content>div#slide1 .box-item span + span {margin:.1em auto .1em auto;}
			
			content>div#slide2 {background-color:#EFEFEF; color:#1b1b1a;}
			content>div#slide2 .unit-box{display: inline-block;width: 20em; font-size: 1em; border: 1px solid #000000; margin:.75em;text-align:left;}
			content>div#slide2 .unit-box h3 {letter-spacing: .05em; display: block; padding: 1em;}
			content>div#slide2 .unit-box div.info{padding:.5em 1em;}
			content>div#slide2 .unit-box div.info:last-child{padding-bottom:1.2em;}
			content>div#slide2 .unit-box div.info.nospace{padding-top:0;}
			content>div#slide2 .unit-box div.info>i {margin-right: .5em; min-width:1.5em; text-align:center; top: 2px;vertical-align: top;position: relative;font-size:1em}
			content>div#slide2 .unit-box div.info>i,
			content>div#slide2 .unit-box div.info>span,
			content>div#slide2 .unit-box div.info>a {display:inline-block;}
			content>div#slide2 .unit-box div.info>a {text-decoration:none; color:#3582c3;}
			
			content>div#slide2 .unit-box.headoffice{background-color:#1b1b1a; color:#d0d0d0; border:1px solid #000000; box-shadow: 0 0 10px #4c4c4c;}
			content>div#slide2 .unit-box.headoffice div.info a{color:#EFEFEF}
			content>div#slide2 .unit-box.tkmutiara{background-color:#fff524; color:#1b1b1a; border:1px solid #a7a010; box-shadow: 0 0 10px #a7a010;}
			content>div#slide2 .unit-box.tkmutiara div.info a{color:#1b1b1a}
			content>div#slide2 .unit-box.tkjiwanala{background-color:#12e202; color:#152d0a; border:1px solid #159e0a; box-shadow: 0 0 10px #159e0a;}
			content>div#slide2 .unit-box.tkjiwanala div.info a{color:#1b1b1a}
			content>div#slide2 .unit-box.tkalkahfi{background-color:#e202aa; color:#ffe8f9; border:1px solid #b7028a; box-shadow: 0 0 10px #b7028a;}
			content>div#slide2 .unit-box.tkalkahfi div.info a{color:#ffe8f9}
			content>div#slide2 .unit-box.sdjiwanala{background-color:#dc0f0f; color:#f5c9c9; border:1px solid #bf0f0f; box-shadow: 0 0 10px #bf0f0f;}
			content>div#slide2 .unit-box.sdjiwanala div.info a{color:#f5c9c9}
			content>div#slide2 .unit-box.smpjiwanala{background-color:#1c79ff; color:#1b1b1a; border:1px solid #175ec3; box-shadow: 0 0 10px #175ec3;}
			content>div#slide2 .unit-box.smpjiwanala div.info a{color:#1b1b1a}
			
			content>div#slide3 .socialbox>i{font-size:6em; padding:.3em .3em .1em .3em;}
			
			content>div#slide4 {background-color:#EFEFEF; color:#1b1b1a;}
		</style>
	</head>    
	<!-- end::Head -->        
		
	<!-- begin::Body -->    
	<body>
		<content>
			<div id="slide1" class="slide">
				<div class="brand wrapper-center">
					<img class="brand" src="./media/img/brand.png"></img>
					<h1 class="brand-name" style="padding:0; margin:0">JIWANALA</h1>
					<p class="brand-sub" style="padding:0; margin:0">Learn | Explore | Lead</p>
				</div>
				<div class="wrapper-center" style="padding: 4em 0 0 0;">
					<h2 class="title">WE'RE UPGRADING</h2>
					<p class="info">Terimakasih telah berkunjung, kami sedang memperbaharui Website.</p>
				</div>
				<div class="wrapper-center">
					<div class="box-item">
						<span id="months">&nbsp;</span>
						<span>BULAN</span>
					</div>
					<div class="box-item">
						<span id="days">&nbsp;</span>
						<span>HARI</span>
					</div>
					<div class="box-item">
						<span id="hours">&nbsp;</span>
						<span>JAM</span>
					</div>
					<div class="box-item">
						<span id="minutes">&nbsp;</span>
						<span>MENIT</span>
					</div>
					<div class="box-item">
						<span id="seconds">&nbsp;</span>
						<span>DETIK</span>
					</div>
				</div>
			</div>
			<div id="slide2" class="slide">
				<div class="wrapper-center">
					<h2 class="title">Our's Students Admission Start on November 1<sup>st</sup> 2018</h2>
					<p class="info">PPDB dibuka tanggal 1 November 2018, untuk informasi silahkan hubungi:</p>
				</div>
				<div class="wrapper-center">
					<div class="unit-box headoffice">
						<h3 style="font-family:Poppins">Head Office</h3>
						<div class="info">
							<i class="fas fa-map-marked-alt"></i>							
							<a jn-activity="maps.headoffice" 
                    		<?php if (getDevice() != 'desktop'): ?>
                    			class="maps android ios" href="https://maps.google.com/?q=-7.321904,112.775326"
                    		<?php else: ?> 
                    			class="maps desktop" href="https://maps.google.com/?q=-7.321904,112.775326" target="_blank"
                    		<?php endif; ?> >
                    			Jl. Raya Kedung Asem No. 47-49, <br>Rungkut, Surabaya - 60289
                    		</a>
						</div>
						<div class="info">
							<i class="fas fa-phone" style=""></i>
							<a class="phone" jn-activity="phone.headoffice" href="tel:+62318701571" target="_blank">+6231 8701 571</a>
						</div>
						<div class="info">
							<i class="fab fa-whatsapp" style=""></i>
							<a jn-activity="whatsapp.headoffice" 
                    		<?php if (getDevice() != 'desktop'): ?>
                    		   class="whatsapp android ios" href="https://api.whatsapp.com/send?phone=6282139907725"
                    		<?php else: ?> 
                    		   class="whatsapp desktop" href="https://api.whatsapp.com/send?phone=6282139907725" target="_blank"
                    		<?php endif; ?> >
                    			+62821 3990 7725
                    		</a>
						</div>
						<div class="info">
							<i class="fas fa-envelope" style=""></i>
							<a class="email" jn-activity="email.headoffice" href="mailto:info@jiwa-nala.org" target="_blank">info@jiwa-nala.org</a>
						</div>
					</div>
					<div class="unit-box tkmutiara">
						<h3 style="font-family:Poppins">TK Islam MUTIARA</h3>
						<div class="info">
							<i class="fas fa-map-marked-alt"></i>
							<a jn-activity="maps.tkmutiara" 
                    		<?php if (getDevice() != 'desktop'): ?>
                    			class="maps android ios" href="https://maps.google.com/?q=-7.322121,112.780311"
                    		<?php else: ?> 
                    			class="maps desktop" href="https://maps.google.com/?q=-7.322121,112.780311" target="_blank"
                    		<?php endif; ?> >
                    			Jl. Raya Kedung Asem Nomor 125, <br>Rungkut, Surabaya - 60289
                    		</a>
		
						</div>
						<div class="info">
							<i class="fas fa-phone" style=""></i>
							<a class="phone" jn-activity="phone.tkmutiara" href="tel:+62318701882" target="_blank">+6231 8701 882</a>
						</div>
						<div class="info">
							<i class="fab fa-whatsapp" style=""></i>							
							<a jn-activity="whatsapp.tkmutiara" 
                    		<?php if (getDevice() != 'desktop'): ?>
                    		   class="whatsapp android ios" href="https://api.whatsapp.com/send?phone=6285736846561"
                    		<?php else: ?> 
                    		   class="whatsapp desktop" href="https://api.whatsapp.com/send?phone=6285736846561" target="_blank"
                    		<?php endif; ?> >
                    			+62857 3684 6561
                    		</a>
						</div>
						<div class="info">
							<i class="fas fa-envelope" style=""></i>
							<a class="email" jn-activity="email.tkmutiara" href="mailto:tkmutiara@jiwa-nala.org" target="_blank">tkmutiara@jiwa-nala.org</a>
						</div>
					</div>
					<div class="unit-box tkjiwanala">
						<h3 style="font-family:Poppins">TK Islam JIWANALA</h3>
						<div class="info">
							<i class="fas fa-map-marked-alt"></i>
							<a jn-activity="maps.tkjiwanala" 
                    		<?php if (getDevice() != 'desktop'): ?>
                    			class="maps android ios" href="https://maps.google.com/?q=-7.321904,112.775326"
                    		<?php else: ?> 
                    			class="maps desktop" href="https://maps.google.com/?q=-7.321904,112.775326" target="_blank"
                    		<?php endif; ?> >
                    			Jl. Raya Kedung Asem No. 47-49, <br>Rungkut, Surabaya - 60289
                    		</a>
						</div>
						<div class="info">
							<i class="fas fa-phone" style=""></i>
							<a class="phone" jn-activity="phone.tkjiwanala" href="tel:+62318709193" target="_blank">+6231 8709 193</a>
						</div>
						<div class="info">
							<i class="fab fa-whatsapp" style=""></i>
							<a jn-activity="whatsapp.tkjiwanala" 
                    		<?php if (getDevice() != 'desktop'): ?>
                    		   class="whatsapp android ios" href="https://api.whatsapp.com/send?phone=6285736846561"
                    		<?php else: ?> 
                    		   class="whatsapp desktop" href="https://api.whatsapp.com/send?phone=6285736846561" target="_blank"
                    		<?php endif; ?> >
                    			+62857 3684 6561
                    		</a>
						</div>
						<div class="info">
							<i class="fas fa-envelope" style=""></i>
							<a class="email" jn-activity="email.tkjiwanala" href="mailto:tkjiwanala@jiwa-nala.org" target="_blank">tkjiwanala@jiwa-nala.org</a>
						</div>
					</div>
					<div class="unit-box tkalkahfi">
						<h3 style="font-family:Poppins">TK Islam Al-Kahfi</h3>
						<div class="info">
							<i class="fas fa-map-marked-alt"></i>
							<a jn-activity="maps.tkalkahfi" 
                    		<?php if (getDevice() != 'desktop'): ?>
                    			class="maps android ios" href="https://maps.google.com/?q=-7.287765,112.576303"
                    		<?php else: ?> 
                    			class="maps desktop" href="https://maps.google.com/?q=-7.287765,112.576303" target="_blank"
                    		<?php endif; ?> >
                    			Desa Sidojangkung, Hulaan, <br>Menganti, Gresik - 61174
                    		</a>
						</div>
						<div class="info">
							<i class="fas fa-phone" style=""></i>
							<a class="phone" jn-activity="phone.tkalkahfi" href="tel:+62318796311" target="_blank">+6231 8796 311</a>
						</div>
						<div class="info">
							<i class="fab fa-whatsapp" style=""></i>
							<a jn-activity="whatsapp.tkalkahfi" 
                    		<?php if (getDevice() != 'desktop'): ?>
                    		   class="whatsapp android ios" href="https://api.whatsapp.com/send?phone=6281357999653"
                    		<?php else: ?> 
                    		   class="whatsapp desktop" href="https://api.whatsapp.com/send?phone=6281357999653" target="_blank"
                    		<?php endif; ?> >
                    			+6281 35799 9653
                    		</a>
						</div>
						<div class="info">
							<i class="fas fa-envelope" style=""></i>
							<a class="email" jn-activity="email.tkalkahfi" href="mailto:tkalkahfi@jiwa-nala.org" target="_blank">tkalkahfi@jiwa-nala.org</a>
						</div>
					</div>
					<div class="unit-box sdjiwanala">
						<h3 style="font-family:Poppins">SD Islam JIWANALA</h3>
						<div class="info">
							<i class="fas fa-map-marked-alt"></i>
							<a jn-activity="maps.sdjiwanala" 
                    		<?php if (getDevice() != 'desktop'): ?>
                    			class="maps android ios" href="https://maps.google.com/?q=-7.321904,112.775326"
                    		<?php else: ?> 
                    			class="maps desktop" href="https://maps.google.com/?q=-7.321904,112.775326" target="_blank"
                    		<?php endif; ?> >
                    			Jl. Raya Kedung Asem No. 47-49, <br>Rungkut, Surabaya - 60289
                    		</a>
						</div>
						<div class="info">
							<i class="fas fa-phone" style=""></i>
							<a class="phone" jn-activity="phone.sdjiwanala" href="tel:+62318792634" target="_blank">+6231 8792 634</a>
						</div>
						<div class="info">
							<i class="fab fa-whatsapp" style=""></i>
							<a jn-activity="whatsapp.sdjiwanala" 
							<?php if (getDevice() != 'desktop'): ?>
                    		   class="whatsapp android ios" href="https://api.whatsapp.com/send?phone=6287853561100"
                    		<?php else: ?> 
                    		   class="whatsapp desktop" href="https://api.whatsapp.com/send?phone=6287853561100" target="_blank"
                    		<?php endif; ?> >
                    			+62878 5356 1100
                    		</a>
						</div>
						<div class="info">
							<i class="fas fa-envelope" style=""></i>
							<a class="email" jn-activity="email.sdjiwanala" href="mailto:sdjiwanala@jiwa-nala.org" target="_blank">sdjiwanala@jiwa-nala.org</a>
						</div>
					</div>
					<div class="unit-box smpjiwanala">
						<h3 style="font-family:Poppins">SMP Islam JIWANALA</h3>
						<div class="info">
							<i class="fas fa-map-marked-alt"></i>
							<a jn-activity="maps.smpjiwanala" 
							<?php if (getDevice() != 'desktop'): ?>
							    class="maps android ios" href="https://maps.google.com/?q=-7.321904,112.775326"
							<?php else: ?> 
							    class="maps desktop" href="https://maps.google.com/?q=-7.321904,112.775326" target="_blank"
							<?php endif; ?> >
							    Jl. Raya Kedung Asem No. 47-49, <br>Rungkut, Surabaya - 60289
							</a>
						</div>
						<div class="info">
							<i class="fas fa-phone" style=""></i>
							<a class="phone" jn-activity="phone.smpjiwanala" href="tel:+62318796311" target="_blank">+6231 8796 311</a>
						</div>
						<div class="info">
							<i class="fab fa-whatsapp" style=""></i>
							<a jn-activity="whatsapp.smpjiwanala" 
							<?php if (getDevice() != 'desktop'): ?>
							   class="whatsapp not-desktop android ios" href="https://api.whatsapp.com/send?phone=6285815099439"
							<?php else: ?> 
							   class="whatsapp desktop" href="https://api.whatsapp.com/send?phone=6285815099439" target="_blank"
							<?php endif; ?> >
							    +62858 1509 9439
                            </a>
						</div>
						<div class="info">
							<i class="fas fa-envelope" style=""></i>
							<a class="email" jn-activity="email.smpjiwanala" href="mailto:smpjiwanala@jiwa-nala.org">smpjiwanala@jiwa-nala.org</a>
						</div>
					</div>
				</div>
			</div>
			<div id="slide3" class="slide">
				<div class="wrapper-center">
					<h2 class="title">Follow Us & Let's be Friend </h2>
					<p class="info">Informasi aktifitas terkini Guru, Staff & Siswa kami tersedia di sosial media. Mari berkenalan lebih dekat !!!</p>
				</div>
				<div class="wrapper-center">
				    
					<a jn-activity="social.facebook" 
					<?php if (getDevice() != 'desktop'): ?>
					    class="socialbox not-desktop android ios" href="fb://profile/100021633470570"
					<?php else: ?> 
					   class="socialbox desktop" href="https://www.facebook.com/koprasi.j.nala" target="_blank"
					<?php endif; ?>>
					    <i class="fab fa-facebook" style="color: #1c79ff;"></i>
					</a>
					
					<!--<a class="socialbox" href="http://instagram.com/_u/jiwa.nala/">-->
					<a jn-activity="social.instagram" 
					<?php if (getDevice() != 'desktop'): ?>
					   class="socialbox not-desktop android ios" href="instagram://user?username=jiwa.nala"
					<?php else: ?> 
					    class="socialbox desktop android ios" href="https://www.instagram.com/jiwa.nala/" target="_blank"
					<?php endif; ?>>
						<i class="fab fa-instagram" style="color: #ff5c35;"></i>
					</a>
					
				</div>
			</div>
			<div id="slide4" class="slide grey" style="padding-top:1em; padding-bottom:1em;">
				<div class="wrapper-center">
					<h3 class="title" style="letter-spacing:.01em; font-weight:500;">&copy JIWANALA 2018</h3>
					<span style="position: relative; bottom: .1em;font-family: Poppins;font-size: .7em;"> by 
					    <a href="mailto:akhmad.musa.hadi@gmail.com">FreezyBits</a>
                    </span>
				</div>
			</div>
		</content>
	</body>
	<!-- end::Body -->
	<script>
		var estimate = function () {
			var start = moment(new Date()),
				end = moment("2019-01-01", "YYYY-MM-DD"),
				diff = end.diff(start),
				duration = moment.duration(diff),
				years = duration.years(),
				months = duration.months(),
				days = duration.days(),
				hrs = duration.hours(),
				mins = duration.minutes(),
				secs = duration.seconds();
			 return {'years':years, 'months': months, 'days':days, 'hours':hrs, 'minutes':mins, 'seconds':secs};
		};
		
		$(document).ready(function(){
			setInterval(function(){
				var remain = estimate();
				$('#months').html(remain.months);
				$('#days').html(remain.days);
				$('#hours').html(remain.hours);
				$('#minutes').html(remain.minutes);
				$('#seconds').html(remain.seconds);
			}, 1000);
			
			var linkHandler = function(evt){
			    evt.preventDefault();
			    var eventType = evt.type,
			        URL = "http://<?php echo $_SERVER[HTTP_HOST]?>/visitor_activity.php",
			        activity = $(this).attr('jn-activity'),
			        href = $(this).attr('href'),
			        isDesktop = $(this).hasClass('desktop'),
			        callback = function(){ 
    			        if (!isDesktop) window.location = href;
    			        else {
    			            var wx = window.open('', '_blank');
    			            wx.location.href = href
    			        }
    			    }
			    $.ajax({type:"GET", data:"activity="+activity, url:URL, success:callback});
			}
			
			//register event listener
			$("a.maps").click(linkHandler);
			$("a.whatsapp").click(linkHandler);
			$("a.phone").click(linkHandler);
			$("a.email").click(linkHandler);
			$("a.socialbox").click(linkHandler);
		});
	</script>
</html>