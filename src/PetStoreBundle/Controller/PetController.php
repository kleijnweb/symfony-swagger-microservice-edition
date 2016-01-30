<?php
/*
 * This file is part of the kleijnweb/symfony-swagger-microservice-edition package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Acme\PetStoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

/**
 * @author John Kleijn <john@kleijnweb.nl>
 */
class PetController
{
    /**
     * @see http://www.petbabynames.com/populardognames.php
     */
    const NAME_RANKING = '
            1	MAX	BELLA
            2	CHARLIE	DAISY
            3	JACK	MOLLY
            4	BUDDY	LUCY
            5	JAKE	SADIE
            6	TUCKER	MAGGIE
            7	DUKE	BAILEY
            8	TOBY	CHLOE
            9	BEAR	SOPHIE
            10	OSCAR	LOLA
            11	COOPER	LILY
            12	SHADOW	ROXY
            13	ROCKY	ZOE
            14	OLIVER	GINGER
            15	RILEY	RUBY
            16	BAILEY	ABBY
            17	JASPER	PRINCESS
            18	LUCKY	GRACIE
            19	BENTLEY	ZOEY
            20	BUSTER	EMMA
            21	HARLEY	ANGEL
            22	GIZMO	SASHA
            23	BANDIT	BELLE
            24	MURPHY	PENNY
            25	BAXTER	LILLY
            26	SAM	LADY
            27	SAMMY	COCO
            28	ZEUS	ELLIE
            29	GUS	LAYLA
            30	JACKSON	HOLLY
            31	CHANCE	DIXIE
            32	SAMSON	LEXI
            33	DEXTER	RILEY
            34	SPARKY	ANNIE
            35	SCOUT	MIA
            36	CODY	MISSY
            37	TYSON	COOKIE
            38	JOEY	LUNA
            39	RUSTY	MADDIE
            40	MILO	STELLA
            41	BO	JASMINE
            42	BOOMER	PIPER
            43	CHICO	CALLIE
            44	BRODY	IZZY
            45	REX	HEIDI
            46	HENRY	SASSY
            47	RUFUS	MISTY
            48	DIESEL	HONEY
            49	WINSTON	ROXIE
            50 	LOUIE	CASEY
    ';

    /**
     * @param Request $request
     *
     * @return array
     */
    public function findPetsByStatus(Request $request)
    {

        $pets = [];
        foreach (explode("\n", self::NAME_RANKING) as $line) {
            $line = trim($line);
            if (!$line) {
                continue;
            }
            list($rank, $a, $b) = explode("\t", ucwords(strtolower($line)));
            foreach ([$a, $b] as $name) {
                $pets[] = [
                    'id'        => (int)$rank + 100,
                    'name'      => $name,
                    'photoUrls' => [],
                    'tags'      => [],
                    'status'    => $request->get('status')[0] //status is array swagger input parameter
                ];
            }
        }

        return $pets;
    }
}
