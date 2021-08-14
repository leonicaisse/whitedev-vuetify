<?php

namespace App\DataFixtures;

use App\Entity\Song;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SongFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $songArray = [
            ["title" => "STAY (with Justin Bieber)", "artist" => "The Kid LAROI", "year" => "2020", "genre" => "Pop", "duration" => 142000],
            ["title" => "INDUSTRY BABY (feat. Jack Harlow)", "artist" => "Lil Nas X", "year" => "2021", "genre" => "Hip-Hop", "duration" => 212000],
            ["title" => "Beggin'", "artist" => "Måneskin", "year" => "2017", "genre" => "Rock", "duration" => 212000],
            ["title" => "Bad Habits", "artist" => "Ed Sheeran", "year" => "2021", "genre" => "Pop", "duration" => 231000],
            ["title" => "good 4 u", "artist" => "Olivia Rodrigo", "year" => "2021", "genre" => "Pop", "duration" => 178000],
            ["title" => "Happier Than Ever", "artist" => "Billie Eilish", "year" => "2021", "genre" => "Pop", "duration" => 299000],
            ["title" => "Kiss Me More (feat. SZA)", "artist" => "Doja Cat", "year" => "2021", "genre" => "Pop", "duration" => 209000],
            ["title" => "Need To Know", "artist" => "Doja Cat", "year" => "2021", "genre" => "Pop", "duration" => 211000],
            ["title" => "MONTERO (Call Me By Your Name)", "artist" => "Lil Nas X", "year" => "2021", "genre" => "Hip-Hop", "duration" => 138000],
            ["title" => "Take My Breath", "artist" => "The Weeknd", "year" => "2021", "genre" => "Disco", "duration" => 220000],
            ["title" => "Pepas", "artist" => "Farruko", "year" => "2021", "genre" => "Pop", "duration" => 287000],
            ["title" => "Todo De Ti", "artist" => "Rauw Alejandro", "year" => "2021", "genre" => "Dance", "duration" => 200000],
            ["title" => "Volví", "artist" => "Aventura", "year" => "2021", "genre" => "Latino", "duration" => 230000],
            ["title" => "I WANNA BE YOUR SLAVE", "artist" => "Måneskin", "year" => "2021", "genre" => "Rock", "duration" => 173000],
            ["title" => "Yonaguni", "artist" => "Bad Bunny", "year" => "2021", "genre" => "Pop", "duration" => 207000],
            ["title" => "Levitating (feat. DaBaby)", "artist" => "Dua Lipa", "year" => "2020", "genre" => "Pop", "duration" => 203000],
            ["title" => "Qué Más Pues?", "artist" => "J Balvin", "year" => "2021", "genre" => "Pop", "duration" => 218000],
            ["title" => "traitor", "artist" => "Oliva Rodrigo", "year" => "2021", "genre" => "Pop", "duration" => 229000],
            ["title" => "Peaches (feat. Daniel Caesar & Giveon)", "artist" => "Justin Bieber", "year" => "2021", "genre" => "Pop", "duration" => 198000],
            ["title" => "Woman", "artist" => "Doja Cat", "year" => "2021", "genre" => "Pop", "duration" => 173000],
            ["title" => "Save Your Tears (with Ariana Grande) (Remix)", "artist" => "The Weeknd", "year" => "2021", "genre" => "Synthpop", "duration" => 191000],
            ["title" => "Butter", "artist" => "BTS", "year" => "2021", "genre" => "Dance", "duration" => 164000],
            ["title" => "deja vu", "artist" => "Olivia Rodrigo", "year" => "2021", "genre" => "Pop", "duration" => 216000],
            ["title" => "Permission to Dance", "artist" => "BTS", "year" => "2021", "genre" => "Dance", "duration" => 188000],
            ["title" => "AM Remix", "artist" => "Nio Garcia", "year" => "2021", "genre" => "Latino", "duration" => 261000],
        ];

        foreach ($songArray as $songItem) {
            $song = (new Song())
                ->setTitle($songItem['title'])
                ->setArtist($songItem['artist'])
                ->setYear($songItem['year'])
                ->setGenre($songItem['genre'])
                ->setDuration($songItem['duration']);

            $manager->persist($song);
        }

        $manager->flush();
    }
}
