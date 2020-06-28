<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramFeedTimeLine;

$datacookie = 'yourcookie';

$readtimeline = new InstagramFeedTimeLine();
$readtimeline->SetCookie($datacookie);

$cursor = false;
$all_data = array();
$count = 0;
$limit = 1;
do {
  
  $post = $readtimeline->Process($cursor);

  if (!$post['status']) {
    echo $post['response'];
    break;
  }
  
  $data = $readtimeline->Extract($post);

  $all_data = array_merge($all_data,$data);

  if ($post['cursor'] !== null) {
    $cursor = $post['cursor'];
  }else{
    $cursor = false;
  }

  $count = $count+1;
} while ($cursor !== false AND $count < $limit);


echo "<pre>";
var_dump($all_data);
echo "</pre>";

/*
array(10) {
  [0]=>
  array(8) {
    ["id"]=>
    string(19) "2341445007397647559"
    ["username"]=>
    string(14) "afri_frizelo27"
    ["code"]=>
    string(11) "CB-e9QnDHTH"
    ["url"]=>
    string(40) "https://www.instagram.com/p/CB-e9QnDHTH/"
    ["type"]=>
    string(5) "video"
    ["media"]=>
    string(234) "https://scontent-sin6-2.cdninstagram.com/v/t50.2886-16/106898878_190802409031389_4176159515911355313_n.mp4?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=109&_nc_ohc=sLjLdMRyMP0AX9IpWOU&oe=5EFAC353&oh=fc7190d9ceea1aa69107effb10b0de3e"
    ["caption"]=>
    string(89) "Pemula Sederhana 🤪🤪
Oke Nnti Kita Buat Vidio Bagoyang Dgn Lagu Nii Biar GG Menn😋"
    ["haslike"]=>
    bool(false)
  }
  [1]=>
  array(8) {
    ["id"]=>
    string(19) "2340752244389037829"
    ["username"]=>
    string(11) "kawankoding"
    ["code"]=>
    string(11) "CB8BcOyAccF"
    ["url"]=>
    string(40) "https://www.instagram.com/p/CB8BcOyAccF/"
    ["type"]=>
    string(8) "carousel"
    ["media"]=>
    array(3) {
      [0]=>
      array(2) {
        ["media"]=>
        string(249) "https://scontent-sin6-1.cdninstagram.com/v/t51.2885-15/e35/s1080x1080/105554068_563327327684946_6488434343549097307_n.jpg?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=106&_nc_ohc=4VJYm9EkriYAX8R65vh&oh=bfc98721986ee5290d6e227c34b27f2e&oe=5F22E2C3"
        ["type"]=>
        string(5) "image"
      }
      [1]=>
      array(2) {
        ["media"]=>
        string(249) "https://scontent-sin6-1.cdninstagram.com/v/t51.2885-15/e35/s1080x1080/105930529_740328946775647_8508512775739762830_n.jpg?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=107&_nc_ohc=Z8nBmLWWjHQAX9xRpju&oh=924c05b4d4379dfe6c4a82c9b3becb23&oe=5F2294F7"
        ["type"]=>
        string(5) "image"
      }
      [2]=>
      array(2) {
        ["media"]=>
        string(249) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/s1080x1080/106109103_264890931271784_7335307256673447302_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=108&_nc_ohc=8jN76lN3D2YAX-rM7C2&oh=302953794d6ba0740766da6471bf0905&oe=5F231D7F"
        ["type"]=>
        string(5) "image"
      }
    }
    ["caption"]=>
    string(696) "Tau gak sih kalo perempuan hanya mengisi 19% dari posisi level menengah di bidang IT dan hanya 18% untuk posisi senior? Padahal, KATANYA, punya skill di bidang IT saat ini bisa jadi pertanda masa depan cerah lho. padahal, KATANYA, prospek IT bakalan subur banget lho beberapa tahun ke depan. ✈️✈️⁣⁣⁣ ⁣⁣⁣ Terus, di mana sih masalahnya? Hayuuu, bahas stereotip dan isu-isu yang sering berkembang di dunia IT bareng speakers kita di kelas Winning the Looping of Stereotype! Yuk, cari tahu bakal seberapa mulus sih career path kamu di bidang IT!⁣⁣⁣ ⁣⁣⁣ Daftar segera di bit.ly/lukangroup! See you in our class! 💻💻⁣⁣⁣ ⁣⁣⁣ @khusniforest X @cynthcecilia"
    ["haslike"]=>
    bool(false)
  }
  [2]=>
  array(8) {
    ["id"]=>
    string(19) "2340079315751541667"
    ["username"]=>
    string(14) "afri_frizelo27"
    ["code"]=>
    string(11) "CB5ob1JnBuj"
    ["url"]=>
    string(40) "https://www.instagram.com/p/CB5ob1JnBuj/"
    ["type"]=>
    string(5) "video"
    ["media"]=>
    string(234) "https://scontent-sin6-1.cdninstagram.com/v/t50.2886-16/105626862_617603849170336_3763470079656290264_n.mp4?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=104&_nc_ohc=L4qqvC6c_lEAX_I9kdN&oe=5EFA8480&oh=d19e502b9aebbf185516172170cdc5b4"
    ["caption"]=>
    string(59) "Pemula Sederhana Dari Indonesia Untuk Indonesia !! 😋😋"
    ["haslike"]=>
    bool(false)
  }
  [3]=>
  array(8) {
    ["id"]=>
    string(19) "2340117238692693346"
    ["username"]=>
    string(12) "twin_mel1719"
    ["code"]=>
    string(11) "CB5xDrpC8Vi"
    ["url"]=>
    string(40) "https://www.instagram.com/p/CB5xDrpC8Vi/"
    ["type"]=>
    string(5) "image"
    ["media"]=>
    string(239) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/106269952_2775855589302317_7275948496166624635_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=105&_nc_ohc=I7DJBZQnGAAAX8qtBlA&oh=a09274ab8d5a156d7f9603d28c208582&oe=5F21778A"
    ["caption"]=>
    string(1076) "🌸C’est l’heure du FollowLoop🌸⠀
.⠀
Prenez part à cette magnifique aventure 100% femmes.⠀
1. Allez sur @maxy_follow_loop le compte où tout se passe. ⠀
2. Likez le post et abonnez vous au compte @maxy_follow_loop et tous ses abonnements (sans cette étape votre commentaire sera effacé, la deuxième fois vous serez bloqué pour garantir une communauté respectueuse et sérieuse)⠀
3. Commentez « c’est parti pour le loop!» sur la publication de @maxy_follow_loop et invitez 3 amies!⠀
4. Les admins n'ont pas l'obligation de rendre les follow⠀
5. Abonnez vous entre personnes qui laissent des commentaires et jouez le jeu.⠀
⠀
Attendez 24h pour les retours.⠀
.⠀
Follow unfollow non toléré et seront bloqués.⠀
.⠀
Suivez les règles pour réussir à obtenir un max de followeuses.⠀
.⠀
Vous devez avoir un compte public pour participer.⠀
#followloop#followforfollow#femmes #mamans##partagedecomptes#instagood#partage#solidarity#woman#womenempowerment#femmestyle#femmesdinfluence#maxiloop#entraide#abonnements#partage"
    ["haslike"]=>
    bool(false)
  }
  [4]=>
  array(8) {
    ["id"]=>
    string(19) "2340653806758995028"
    ["username"]=>
    string(12) "twin_mel1719"
    ["code"]=>
    string(11) "CB7rDxmCSRU"
    ["url"]=>
    string(40) "https://www.instagram.com/p/CB7rDxmCSRU/"
    ["type"]=>
    string(5) "image"
    ["media"]=>
    string(249) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/s1080x1080/106247564_319899465839066_7690177101325939709_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=102&_nc_ohc=exlRpVSUNMwAX9awcly&oh=b44980f8b633e2385a85213f8ea5751e&oe=5F21BC2B"
    ["caption"]=>
    string(310) "𝘽𝙤𝙣 𝙬𝙚𝙚𝙠-𝙚𝙣𝙙 𝙡𝙖 𝙏𝙚𝙖𝙢 🤗
.
Quoi de prévu aujourd’hui nous sa sera shopping et vous ?🤗🤗
•
•
•
•
•
•
#fashionstyle #fashionblogger #kidsfashion #kidsmodel #kidsmodel #mode #modefashion #girly #instamode #lookdujour #styleoftheday #cutefashion"
    ["haslike"]=>
    bool(false)
  }
  [5]=>
  array(8) {
    ["id"]=>
    string(19) "2339831590811255449"
    ["username"]=>
    string(12) "twin_mel1719"
    ["code"]=>
    string(11) "CB4wG9UisKZ"
    ["url"]=>
    string(40) "https://www.instagram.com/p/CB4wG9UisKZ/"
    ["type"]=>
    string(5) "image"
    ["media"]=>
    string(249) "https://scontent-sin6-1.cdninstagram.com/v/t51.2885-15/e35/p1080x1080/106414550_632683517605746_4247331758696252653_n.jpg?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=106&_nc_ohc=8LhFugPRAPgAX8SjRET&oh=2c3a343cc51f59f32ecb506b19f28ab5&oe=5F228A04"
    ["caption"]=>
    string(120) "•Vogue•
•
•
•
•
•
#voguechallenge #twins #kids #kidsfashion #igfashion #twinsisters #amour #instakidsmodel"
    ["haslike"]=>
    bool(false)
  }
  [6]=>
  array(8) {
    ["id"]=>
    string(19) "2340475324594157393"
    ["username"]=>
    string(11) "kawankoding"
    ["code"]=>
    string(11) "CB7CehIAHdR"
    ["url"]=>
    string(40) "https://www.instagram.com/p/CB7CehIAHdR/"
    ["type"]=>
    string(5) "image"
    ["media"]=>
    string(239) "https://scontent-sin6-1.cdninstagram.com/v/t51.2885-15/e35/105302275_1172072336476024_8531216213752737337_n.jpg?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=104&_nc_ohc=FKQcb8PqFKoAX-K2Ir5&oh=0b8591109f65cef949eabf3bc2d4ebf1&oe=5F2264F9"
    ["caption"]=>
    string(607) "KAWAN KODING BANGET NIH

Banyak yang komentar waktu saya nulis artikel tentang membuat website seperti Kawan Koding. Banyak yang mengira saya menggunakan Laravel sebagai "engine" Blog di Kawan Koding.

Mereka semua salah, di sini saya cuma mau sedikit menyampaikan, untuk membuat konten, berbagi, kita bisa mulai dengan hal yang sederhana alias "praktis". Tujuannya adalah menyampaikan hal yang ingin disampaikan, bukan sekedar keren kerenan teknologi.

Perspektif ini tentu tidak berlaku untuk "developer" beneran ya yang pengen eksploroasi & optimasi segala lini dalam websitenya 🙂 #CMIIW

#kawankoding"
    ["haslike"]=>
    bool(false)
  }
  [7]=>
  array(8) {
    ["id"]=>
    string(19) "2340661754312918445"
    ["username"]=>
    string(11) "babyboyarda"
    ["code"]=>
    string(11) "CB7s3bVKgWt"
    ["url"]=>
    string(40) "https://www.instagram.com/p/CB7s3bVKgWt/"
    ["type"]=>
    string(5) "image"
    ["media"]=>
    string(250) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/p1080x1080/106111825_2648641025409356_2092262424244286613_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=108&_nc_ohc=4dPfEUicvnUAX9GuqbH&oh=858f21c384dd1a6a8ef0b5568d94c53c&oe=5F229E86"
    ["caption"]=>
    string(63) "It‘s my birthday 🥳
- 
Anzeige/Werbung - 
#ootd#tb#birthday"
    ["haslike"]=>
    bool(false)
  }
  [8]=>
  array(8) {
    ["id"]=>
    string(19) "2340308182687186463"
    ["username"]=>
    string(13) "alexisnemorin"
    ["code"]=>
    string(11) "CB6ceSGAn4f"
    ["url"]=>
    string(40) "https://www.instagram.com/p/CB6ceSGAn4f/"
    ["type"]=>
    string(5) "image"
    ["media"]=>
    string(250) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/p1080x1080/105937323_3194946817235513_1031154426447459011_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=105&_nc_ohc=IDKfnWH32JYAX-wp28x&oh=161290acb6b20e4fe5236ff37300f091&oe=5F22D9D1"
    ["caption"]=>
    string(60) "i know I’m special b/c God chose me to be your mother 💚"
    ["haslike"]=>
    bool(false)
  }
  [9]=>
  array(8) {
    ["id"]=>
    string(19) "2340198899636416708"
    ["username"]=>
    string(13) "drmarioademaj"
    ["code"]=>
    string(11) "CB6DoAUlrDE"
    ["url"]=>
    string(40) "https://www.instagram.com/p/CB6DoAUlrDE/"
    ["type"]=>
    string(5) "image"
    ["media"]=>
    string(238) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/105928461_819988198532468_5058600199454199270_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=108&_nc_ohc=_06SWip67V8AX-kbaMR&oh=d9ed6f2f06e415a7339e7bc5343da1ca&oe=5F216D21"
    ["caption"]=>
    string(251) "Proud to have this little superstar represent our Children's Multivitamins from @physiciansgarden 🌱😍 www.physiciansgarden.com 
#BestVitamins .
.
.
.
.
#vitamins #bestvitamins #health #fitness #wellness #natural #kids #children #model #moms #dads"
    ["haslike"]=>
    bool(false)
  }
}
*/