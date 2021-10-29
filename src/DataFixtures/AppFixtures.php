<?php

namespace App\DataFixtures;

use App\Entity\Group;
use App\Entity\Picture;
use App\Entity\Trick;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function getTrickData(): array
    {
        $group1 = new Group();
        $group1->setName('Figures aériennes');

        $group2 = new Group();
        $group2->setName('Figures de surface');

        $group3 = new Group();
        $group3->setName('Figures sur rails');

        $tricks = [
            [
                'Ollies',
                "Un Ollie est l'un des sauts les plus réguliers utilisant la queue de votre Snowboard comme ressort. Cette figure est le mouvement de base pour de nombreuses figures aériennes et elle est également utile pour sauter par-dessus de petits obstacles. Dans cette section, apprenez à réaliser un Ollie.
                ÉTAPE 1 : Pour commencer, trouvez une pente douce avec le moins de trafic possible. Vous aurez besoin d'un espace relativement large pour cette figure de snowboard.
                ÉTAPE 2 : Accroupissez-vous légèrement sur votre planche, en déplaçant votre poids vers votre pied arrière. Pour de nombreux débutants, il est normal de baisser les yeux vers votre planche lorsque vous commencez les ollies. Vous apprendrez à regarder droit devant vous au fur et à mesure que vous vous habituerez à faire cette figure.
                ÉTAPE 3 : Commencez à déplacer votre poids sur votre pied arrière pour enlever la pression de votre pied avant. Soulevez le nez de votre snowboard et utilisez la queue comme ressort pour vous faire décoller.
                ÉTAPE 4 : Une fois que votre pied avant a décollé, levez vos genoux vers votre poitrine, en gardant la planche centrée sous vous.
                ÉTAPE 5 : Pour atterrir, posez le nez de la planche. Vous pouvez également poser les deux pieds en même temps. Pliez vos genoux pour absorber l'impact de l'atterrissage.
                ÉTAPE 6 : Une fois que l'ensemble de ton snowboard touche le sol, repars et répète les étapes précédentes jusqu'à ce que tu sois à l'aise.
                Les ollies sont très utiles si tu veux éviter les atterrissages en aveugle et les obstacles comme les rochers et les branches lorsque tu te déplaces rapidement. Entraînez-vous et soyez à l'aise dans l'exécution de cette figure. Une fois que vous maîtriserez les ollies, vous pourrez apprendre d'autres figures et manœuvres aériennes.",
                '<iframe src="https://www.youtube.com/embed/AnI7qGQs0Ic" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                $group1,
                'ollie.jpg'
            ],
            [
                'Air to Fakie',
                "L'Air to Fakie consiste à faire un virage à 180 degrés dans les airs, puis à revenir en arrière après le virage. Ce tour de snowboard est un excellent moyen de te préparer à t'habituer à te déplacer dans les airs. Cela vous donnera également une idée de base de ce que l'on ressent en faisant des manœuvres aériennes. Dans cette section, apprenez à réaliser un Air to Fakie :
                ÉTAPE 1 : Trouvez une pente douce avec le moins de trafic humain possible. Commencez à descendre la pente en ligne droite à une vitesse modérée.
                ÉTAPE 2 : Pour amorcer le virage, tournez vos hanches et vos épaules dans le sens de la rotation. Accroupissez-vous et n'oubliez pas de transférer votre poids sur votre pied arrière.
                ÉTAPE 3 : Soulevez votre planche - d'abord le nez, puis le derrière. Essayez de garder votre équilibre pendant cette opération.
                ÉTAPE 4 : Sautez et tournez à 180 degrés.
                ÉTAPE 5 : Après le virage, posez les deux pieds en même temps. Cela permet de diviser l'impact et de réduire le risque de glisser lorsque vous atterrissez.
                ÉTAPE 6 : Faites un tour après le virage. Répétez les étapes et continuez à vous entraîner jusqu'à ce que vous soyez à l'aise pour tourner en l'air et reculer.
                Air to Fakie est l'un des tours de snowboard que vous devez connaître si vous souhaitez essayer d'autres cascades aériennes. Il s'agit d'un bon exercice pour affiner vos mouvements et vous mettre à l'aise pour faire des pirouettes dans les airs. Avec suffisamment de pratique et de détermination à apprendre, vous parviendrez finalement à réaliser d'autres figures avancées.",
                '<iframe src="https://www.youtube.com/embed/TjaYuW9v0dA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                $group1,
                'airtofakie.jpg'
            ],
            [
                'Wheelies',
                "Un Wheelie consiste à glisser avec une pointe de votre planche en l'air. Cette figure consiste à maintenir votre équilibre tout en ne surfant que sur une seule extrémité de votre planche. En développant la puissance et la technique nécessaires pour soulever le nez ou la queue de votre snowboard, vous vous préparerez à réaliser des figures plus avancées. Dans cette section, apprenez à réaliser des Wheelies :
                ÉTAPE 1 : Les Wheelies avec le nez de votre planche en l'air sont très faciles à réaliser. Pour commencer, trouvez une pente douce avec le moins de trafic humain possible.
                ÉTAPE 2 : Descendez la pente à vitesse modérée. Pour amorcer la figure, accroupissez-vous légèrement et penchez-vous en arrière.
                ÉTAPE 3 : Déplacez votre poids sur votre pied arrière et soulevez votre pied avant. Essayez de garder cette position pendant quelques secondes. Maintenez votre équilibre pendant que le nez de la planche est en l'air.
                ÉTAPE 4 : Revenez à votre première position et posez votre pied avant. Répétez ces étapes jusqu'à ce que vous soyez à l'aise en ne surfant que sur le derrière de votre planche.
                Il se peut que vous tombiez en arrière les premières fois que vous essayez de faire un Wheelie. Cela prend du temps et de la pratique. Vous pouvez également essayer de faire un Nose Wheelie dans lequel vous chevaucherez le nez de la planche. Une fois que vous avez maîtrisé les Wheelies, vous pouvez passer à d'autres mouvements de snowboard.",
                '<iframe src="https://www.youtube.com/embed/AKC80-zYU1c" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                $group2,
                'wheelie.jpg'
            ],
            [
                'Butter',
                "Butter est une figure au sol intéressante qui consiste à effectuer une série de virages à 360 degrés. Cette figure peut être réalisée sur une pente modérée, ce qui permet d'augmenter la vitesse et les mouvements. De plus, d'autres techniques de snowboard peuvent être intégrées à cette figure. Dans cette section, apprenez à exécuter les Butters de base :
                ÉTAPE 1 : Trouvez une pente modérée avec le moins de trafic humain possible. Commencez à rouler en ligne droite vers le bas de la pente.
                ÉTAPE 2 : Soulevez l'arrière de la planche et pivotez sur l'avant pour tourner l'arrière vers l'avant.
                ÉTAPE 3 : Continuez à tourner avec le nez de la planche en l'air. Ne l'élevez pas trop haut afin de pouvoir maintenir votre équilibre et éviter de tomber.
                ÉTAPE 4 : Posez le nez de la planche à mi-chemin du virage. À ce stade, effectuez une rotation au sol pour terminer le virage.
                ÉTAPE 5 : Continuez la rotation au sol jusqu'à ce que vous reveniez à votre position initiale.
                ÉTAPE 6 : Vous avez maintenant terminé le Butter de base.
                Continuez à vous entraîner jusqu'à ce que vous soyez à l'aise dans l'exécution du Butter de base. Une fois que vous vous serez habitué à l'exécuter, vous pourrez passer à d'autres figures de snowboard.",
                '<iframe src="https://www.youtube.com/embed/UcamamLlbPg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                $group2,
                'butter.jpg'
            ],
            [
                'Nose and Tail Rolls',
                "Le Nose and Tail Roll consiste à utiliser le nez ou le queue de votre planche pour effectuer une rotation de 180 degrés et ainsi changer votre position. Cette figure est une façon de passer du fakie au regular et vice versa. C'est similaire à un Wheelie, mais vous ajoutez un virage à 180 degrés. Par conséquent, vous devez d'abord savoir comment faire un Wheelie et être à l'aise pour le faire. Dans cette section, vous apprendrez à effectuer des Nose and Tail Rolls :
                ÉTAPE 1 : Sur une pente douce, descendez directement la pente à vitesse modérée. Étant donné qu'un Nose and Tail Roll implique de faire un Wheelie, vous allez d'abord soulever le derrière de la planche avant de tourner à 180 degrés.
                ÉTAPE 2 : Accroupissez-vous légèrement et déplacez votre poids sur votre pied avant. Soulevez la queue de votre planche. Une fois qu'elle a décollé, effectuez un virage à 180 degrés en utilisant le nez de la planche comme point de pivot.
                ÉTAPE 3 : Notez que la queue de votre planche est élevé pendant le virage. Maintenez votre équilibre jusqu'à ce que vous ayez terminé le virage à 180 degrés.
                ÉTAPE 4 : Après le virage, remarquez que vous avez réussi à changer votre position. Continuez à vous entraîner jusqu'à ce que vous ayez l'habitude de faire cette figure.
                Lors d'un Nose ou Tail Roll, il est essentiel de maintenir votre équilibre et d'avoir un timing parfait. Ne soulevez pas trop votre planche pour éviter de tomber. Assurez-vous de vous entraîner à faire cette figure jusqu'à ce que vous soyez à l'aise avec elle.",
                '<iframe src="https://www.youtube.com/embed/N3ddt_yoxts" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                $group2,
                'nose-and-tail-rolls.jpg'
            ],
            [
                '50/50 Grinds',
                "Dans sa forme la plus simple, le grinding consiste à glisser sur des éléments autres que la neige, comme les rails, les rampes et les boîtes. Il y a beaucoup de figures et de mouvements qui peuvent être faits sur des rails. Le plus fondamental est le 50/50 Grind. C'est aussi le grind le plus facile à apprendre. Notez simplement que vous devez être à l'aise avec les Ollies avant d'essayer ce grind. Suivez les étapes ci-dessous pour apprendre à réaliser un 50/50 Grind :
                ÉTAPE 1 : Cherchez un bon endroit pour le grind. Trouvez une rampe de snowboard qui n'est pas trop haute afin que vous puissiez exécuter un Ollie avec facilité.
                ÉTAPE 2 : L'approche est très importante pour un grind 50/50, car elle permet à votre planche de rester plate et droite sur le rail. Descendez le long du rail en gardant votre vitesse sous contrôle.
                ÉTAPE 3 : Effectuez un bon décollage afin de rester équilibré et de garder le contrôle. Accroupissez-vous légèrement et faites un petit Ollie pour atteindre le rail, avec votre planche complètement sur sa surface.
                ÉTAPE 4 : Effectuez simplement un grind comme si vous étiez sur la neige. Gardez votre planche parallèle à la rampe de snowboard. Maintenez votre équilibre et laissez-vous aller au grind.
                ÉTAPE 5 : Pour descendre, faites un petit Ollie lorsque vous atteignez l'extrémité du rail. Ayez un timing parfait pour éviter une sortie prématurée.
                ÉTAPE 6 : Atterrissez avec les deux pieds et repartez.
                Il faut un peu de pratique et de patience pour réussir à faire des 50/50 Grinds avec facilité. Assurez-vous d'abord de perfectionner vos ollies afin de minimiser les problèmes que vous pourriez rencontrer lors de vos mouvements sur les rails de snowboard.",
                '<iframe src="https://www.youtube.com/embed/NeY6sSsbbZw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                $group3,
                'grinds.jpg'
            ],
            [
                'Rock-n-Roll Grinds',
                "Rock-n-Roll Grind est une autre figure que vous pouvez faire sur le rail. Dans cette manœuvre, tu dois garder ta planche en travers du rail tout en grindant. Assurez-vous d'abord de perfectionner vos Ollies ainsi que vos virages avant d'exécuter ce Grind. Dans cette section, apprenez à exécuter un Rock-n-Roll Grind.
                ÉTAPE 1 : Il est essentiel de noter que l'approche et le timing sont très importants lors d'un Rock-n-Roll Grind. Roulez vers le rail, en contrôlant votre vitesse.
                ÉTAPE 2 : Prenez un bon départ afin de rester équilibré et de garder le contrôle. Faites un Ollie pour atteindre la surface du rail.
                ÉTAPE 3 : Déplacez votre planche de manière à ce qu'elle soit perpendiculaire au rail. Afin de maintenir l'équilibre, assurez-vous que le milieu de la planche est sur la surface, tandis que le nez et la queue sont de chaque côté.
                ÉTAPE 4 : Faites simplement du grind comme si vous étiez sur la neige. Gardez votre planche en travers du rail. Restez en équilibre et allez-y avec le grind.
                ÉTAPE 5 : Faites un autre Ollie lorsque vous atteignez la fin du rail. Ayez un timing parfait pour éviter une sortie prématurée.
                ÉTAPE 6 : Atterrissez avec les deux pieds et repartez.
                Tout comme pour les grinds 50/50, assurez-vous d'avoir la bonne approche, le bon équilibre et le bon timing pour les grinds Rock-n-Roll. Continuez à vous entraîner jusqu'à ce que vous soyez à l'aise.",
                '<iframe src="https://www.youtube.com/embed/uHwnlYzACKk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                <iframe src="https://www.youtube.com/embed/ALA_yTMs3qw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                $group3,
                'rock-n-roll-grind.jpg'
            ],
            [
                '180 Grinds',
                "Un grind 180 est un trick sur le rail qui implique un virage à 180 degrés au début et à la fin du grind. Cela vous aidera à affiner votre mouvement dans l'air et vous enseignera l'importance de l'équilibre, du timing et de l'approche. Assurez-vous d'être déjà à l'aise avec les Ollies et la réalisation de virages avant d'essayer ce tour.
                ÉTAPE 1 : Cherchez un bon endroit pour grinder. Comme vous allez tourner à 180 degrés au début du trick, trouvez un rail qui n'est pas trop haut pour vous.
                ÉTAPE 2 : Comme pour toutes les autres figures réalisées sur des rails, faites attention à l'approche et au timing. Accroupissez-vous légèrement lorsque vous vous approchez du rail et soyez prêt à tourner.
                ÉTAPE 3 : Tournez à 180 degrés. Assurez-vous que votre planche atterrit complètement sur la surface du rail.
                ÉTAPE 4 : Faites comme si vous étiez sur la neige. Gardez votre planche parallèle au rail. Gardez votre équilibre et laissez-vous aller à la vitesse.
                ÉTAPE 5 : Pour descendre, faites un virage à 180 degrés lorsque vous atteignez l'extrémité du rail.
                ÉTAPE 6 : Atterrissez avec vos deux pieds et repartez.
                Faire des spins sur des rails peut vous donner du fil à retordre. Continuez à vous entraîner pour obtenir le bon timing lorsque vous tournez sur le rail et en sortez.",
                '<iframe src="https://www.youtube.com/embed/9p7RwPA1whs" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                $group3,
                '180-grinds.jpg'
            ],
            [
                'Five-O Grinds',
                "Une autre manœuvre que vous pouvez essayer sur les rails est un Five-O Grind. Dans cette figure, vous ferez un Wheelie au lieu de simplement grinder avec la planche à plat sur le rail. Il est donc nécessaire d'apprendre à faire un Wheelie sur la neige avant de l'essayer sur les rails. Dans cette section, apprenez à exécuter un Five-O Grind.
                ÉTAPE 1 : Cherchez un bon endroit pour le grind. Trouvez un rail qui n'est pas trop haut pour vous.
                ÉTAPE 2 : Faites un Nose Wheelie lorsque vous atteignez le rail. Ne vous avancez pas trop. Cela vous ferait perdre l'équilibre pendant le grind.
                ÉTAPE 3 : Continuez le grind en utilisant le nez de la planche comme point de pivot. Maintenez votre équilibre et ne soulevez pas trop le talon de la planche.
                ÉTAPE 4 : Posez la queue de la planche lorsque vous atteignez l'extrémité du rail. Si vous sortez du rail lors d'un Nose Wheelie, vous risquez d'avoir un atterrissage difficile.
                ÉTAPE 5 : Sortez du rail, atterrissez avec les deux pieds, puis partez.
                Vous pouvez également essayer de faire un Five-O Grind en utilisant la queue de votre planche comme point de pivot. Il faut un peu de pratique et de patience pour s'habituer à faire des Wheelies sur des rails. Assurez-vous d'abord de réviser vos Wheelies sur la neige pour minimiser les problèmes que vous pourriez rencontrer en effectuant des mouvements sur les rails.",
                '<iframe src="https://www.youtube.com/embed/6GgJl4VHNq0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                $group3,
                'five-o-grinds.jpg'
            ],
            [
                'Course - Traverser',
                "Si le glissement latéral consiste à glisser le long de la ligne de pente en utilisant le talon ou la pointe du pied pour contrôler la descente, la traversée est une compétence qui vous permet de passer d'un côté à l'autre de la pente tout en descendant progressivement. Vous pouvez utiliser le côté orteils ou le côté talon pour les traversées. Dans cette section, apprenez à traverser en utilisant la carre des orteils de votre snowboard :
                ÉTAPE 1 : Pour traverser en utilisant la bordure d'orteil, il est très important de regarder dans la direction où vous voulez aller. Écartez vos bras pour vous aider à maintenir votre équilibre.
                ÉTAPE 2 : Ensuite, tournez votre tête et le haut de votre corps vers la direction où vous souhaitez vous rendre. Mettez plus de poids sur votre pied avant et déplacez-vous avec votre autre pied.
                ÉTAPE 3 : Remettez votre snowboard dans sa position initiale, de l'autre côté de la ligne de chute. Préparez-vous à passer de l'autre côté de la pente. Regardez dans la direction où vous voulez aller.
                ÉTAPE 4 : Comme à l'étape 2, tournez votre tête et le haut de votre corps vers la direction vers laquelle vous souhaitez vous diriger. Mettez plus de poids sur votre pied de tête et avancez avec votre autre pied.
                La maîtrise de cette compétence peut vous aider à contrôler votre vitesse et votre direction. Continuez à vous entraîner jusqu'à ce que vous vous sentiez à l'aise en traversant. Bientôt, vous pourrez contrôler les deux bords et vous pourrez faire un arrêt contrôlé si nécessaire. Avant d'essayer d'autres exercices de snowboard, assurez-vous que vous êtes déjà à l'aise pour effectuer des traversées (côté talon et côté orteil).",
                '<iframe src="https://www.youtube.com/embed/YsoidLgTR1g" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                <iframe src="https://www.youtube.com/embed/lN5EeiomqkQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                <iframe src="https://www.youtube.com/embed/D53buuJO9ZI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                $group3,
                'sidedlipping.jpg'
            ],
        ];

        return $tricks;
    }

    public function load(ObjectManager $manager): void
    {        
        $tricks = $this->getTrickData();

        foreach ($tricks as [$name, $description, $tagsVideo, $group, $pictureName]) {
            $picture = new Picture();
            $trick = new Trick();

            $picture
                ->setName($pictureName)
                ->setTrick($trick) // vérifier si ça marche bien
            ;

            $trick
                ->setName($name)
                ->setSlug($this->slugger->slug($trick->getName()))
                ->setDescription($description)
                ->addPicture($picture)
                ->setTagsVideo($tagsVideo)
                ->setRelatedGroup($group)
            ;
        }

    }
}
