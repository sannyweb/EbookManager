CREATE SCHEMA IF NOT EXISTS `ebookmanager` DEFAULT CHARACTER SET utf8 ;
USE `ebookmanager` ;


CREATE TABLE IF NOT EXISTS `ebookmanager`.`Usuarios` (
  `idUsuarios` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(80) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `senha` VARCHAR(200) NOT NULL,
  `tipo` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idUsuarios`))
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `ebookmanager`.`Generos` (
  `idGeneros` INT NOT NULL AUTO_INCREMENT,
  `generos` VARCHAR(45) NULL,
  PRIMARY KEY (`idGeneros`))
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `ebookmanager`.`Livros` (
  `idLivros` INT NOT NULL AUTO_INCREMENT,
  `idUsuarios` INT NOT NULL,
  `idGeneros` INT NOT NULL,
  `caminhoCover` VARCHAR(100) NULL,
  `titulo` VARCHAR(70) NULL,
  `tituloOriginal` VARCHAR(70) NULL,
  `editora` VARCHAR(45) NULL,
  `autor` VARCHAR(40) NULL,
  `anoPublicacao` VARCHAR(400) NULL,
  `paginas` INT NULL,
  `sinopse` VARCHAR(700) NULL,
  `aboutAutor` VARCHAR(1000) NULL,
  `visitas` VARCHAR(45) NULL,
  `status` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idLivros`),
    FOREIGN KEY (`idUsuarios`)
    REFERENCES `ebookmanager`.`Usuarios` (`idUsuarios`),
    FOREIGN KEY (`idGeneros`)
    REFERENCES `ebookmanager`.`Generos` (`idGeneros`))
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `ebookmanager`.`Managers` (
  `idManagers` INT NOT NULL AUTO_INCREMENT,
  `idUsuarios` INT NOT NULL,
  `titulo` VARCHAR(100) NULL,
  `autor` VARCHAR(100) NULL,
  `tamanhoEpub` VARCHAR(100) NULL,
  `caminhoEpub` VARCHAR(45) NULL,
  `nivel` VARCHAR(45) NULL,
  PRIMARY KEY (`idManagers`),
    FOREIGN KEY (`idUsuarios`)
    REFERENCES `ebookmanager`.`Usuarios` (`idUsuarios`))
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `ebookmanager`.`Tags` (
  `idTags` INT NOT NULL AUTO_INCREMENT,
  `tags` VARCHAR(45) NULL,
  PRIMARY KEY (`idTags`))
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `ebookmanager`.`Livros_Tags` (
  `idLivros_Tags` INT NOT NULL AUTO_INCREMENT,
  `idLivros` INT NOT NULL,
  `idTags` INT NOT NULL,
  PRIMARY KEY (`idLivros_Tags`),
    FOREIGN KEY (`idLivros`)
    REFERENCES `ebookmanager`.`Livros` (`idLivros`),
    FOREIGN KEY (`idTags`)
    REFERENCES `ebookmanager`.`Tags` (`idTags`))
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `ebookmanager`.`Comentarios` (
  `idComentarios` INT NOT NULL AUTO_INCREMENT,
  `idUsuarios` INT NOT NULL,
  `idLivros` INT NOT NULL,
  `texto` VARCHAR(500) NULL,
  `data` VARCHAR(45) NULL,
  `aceito` VARCHAR(45) NULL,
  PRIMARY KEY (`idComentarios`),
    FOREIGN KEY (`idUsuarios`)
    REFERENCES `ebookmanager`.`Usuarios` (`idUsuarios`),
    FOREIGN KEY (`idLivros`)
    REFERENCES `ebookmanager`.`Livros` (`idLivros`))
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `ebookmanager`.`Resenhas` (
  `idResenhas` INT NOT NULL AUTO_INCREMENT,
  `idUsuarios` INT NOT NULL,
  `idLivros` INT NOT NULL,
  `titulo` VARCHAR(200) NULL,
  `texto` VARCHAR(200) NULL,
  `datepost` VARCHAR(200) NULL,
  PRIMARY KEY (`idResenhas`),
   FOREIGN KEY (`idLivros`)
    REFERENCES `ebookmanager`.`Livros` (`idLivros`),
    FOREIGN KEY (`idUsuarios`)
    REFERENCES `ebookmanager`.`Usuarios` (`idUsuarios`))
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `ebookmanager`.`Destaques` (
  `idDestaques` INT NOT NULL AUTO_INCREMENT,
  `idLivros` VARCHAR(45) NULL,
  `dataTrocar` DATE NULL,
  PRIMARY KEY (`idDestaques`))
ENGINE = InnoDB;


INSERT INTO `Generos` (`idGeneros`,`generos`) VALUES (1,'Fantasia');
INSERT INTO `Generos` (`idGeneros`,`generos`) VALUES (2,'Thiller');
INSERT INTO `Generos` (`idGeneros`,`generos`) VALUES (3,'Terror');
INSERT INTO `Generos` (`idGeneros`,`generos`) VALUES (4,'Comédia');
INSERT INTO `Generos` (`idGeneros`,`generos`) VALUES (5,'Drama');
INSERT INTO `Generos` (`idGeneros`,`generos`) VALUES (6,'Romance');
INSERT INTO `Generos` (`idGeneros`,`generos`) VALUES (7,'Ficção Científica');
INSERT INTO `Generos` (`idGeneros`,`generos`) VALUES (8,'Psicológico');
INSERT INTO `Generos` (`idGeneros`,`generos`) VALUES (9,'Biografia');
INSERT INTO `Generos` (`idGeneros`,`generos`) VALUES (10,'Suspense');
INSERT INTO `Generos` (`idGeneros`,`generos`) VALUES (11,'Mistério');

INSERT INTO `Tags` (`idTags`,`tags`) VALUES (1,'comédia');
INSERT INTO `Tags` (`idTags`,`tags`) VALUES (2,'jornada do herói');
INSERT INTO `Tags` (`idTags`,`tags`) VALUES (3,'romance');
INSERT INTO `Tags` (`idTags`,`tags`) VALUES (4,'romance juvenil');
INSERT INTO `Tags` (`idTags`,`tags`) VALUES (5,'adulto');
INSERT INTO `Tags` (`idTags`,`tags`) VALUES (6,'morte');
INSERT INTO `Tags` (`idTags`,`tags`) VALUES (7,'reviravolta');
INSERT INTO `Tags` (`idTags`,`tags`) VALUES (8,'poderes');
INSERT INTO `Tags` (`idTags`,`tags`) VALUES (9,'viagens no tempo');
INSERT INTO `Tags` (`idTags`,`tags`) VALUES (10,'abandono');
INSERT INTO `Tags` (`idTags`,`tags`) VALUES (11,'superação');
INSERT INTO `Tags` (`idTags`,`tags`) VALUES (12,'traição');
INSERT INTO `Tags` (`idTags`,`tags`) VALUES (13,'naves espaciais');
INSERT INTO `Tags` (`idTags`,`tags`) VALUES (14,'apocalipse');
INSERT INTO `Tags` (`idTags`,`tags`) VALUES (15,'pós-apocaliptivo');
INSERT INTO `Tags` (`idTags`,`tags`) VALUES (16,'Cliche');
INSERT INTO `Tags` (`idTags`,`tags`) VALUES (17,'linhas do tempo');
INSERT INTO `Tags` (`idTags`,`tags`) VALUES (18,'nerd');
INSERT INTO `Tags` (`idTags`,`tags`) VALUES (19,'acidentes');
INSERT INTO `Tags` (`idTags`,`tags`) VALUES (20,'coisas inesperadas');
INSERT INTO `Tags` (`idTags`,`tags`) VALUES (21,'surpresas');
INSERT INTO `Tags` (`idTags`,`tags`) VALUES (22,'pistas ');
INSERT INTO `Tags` (`idTags`,`tags`) VALUES (23,'plot twist');
INSERT INTO `Tags` (`idTags`,`tags`) VALUES (24,'busca de algo maior');
INSERT INTO `Tags` (`idTags`,`tags`) VALUES (25,'perfeccionismo');
INSERT INTO `Tags` (`idTags`,`tags`) VALUES (26,'frio');
INSERT INTO `Tags` (`idTags`,`tags`) VALUES (27,'solidao');

INSERT INTO `Usuarios` (`idUsuarios`,`username`,`email`,`senha`,`tipo`) VALUES (1,'ruanx14','ruanx14@gmail.com','$2y$10$rt54vgpv1v6KgVB6bNWVbuXXVEh0TH9TfrmRYyszVMRcZBj.N624a','ADMINISTRADOR');
INSERT INTO `Usuarios` (`idUsuarios`,`username`,`email`,`senha`,`tipo`) VALUES (2,'alysson','alysson@gmail.com','$2y$10$LvycLT0fs7qzbjBPnpnPOeFDJyn3I9fpv0KM1k8wq3tY892VGPE2u','ADMINISTRADOR');
INSERT INTO `Usuarios` (`idUsuarios`,`username`,`email`,`senha`,`tipo`) VALUES (3,'fernando','fernando@gmail.com','$2y$10$n46k7AtgIwxymyLKX5jOV.bqdSfcpk5yV/n8HRfNiHsoVTxBl7VdG','USUARIO');
INSERT INTO `Usuarios` (`idUsuarios`,`username`,`email`,`senha`,`tipo`) VALUES (4,'jonas','jonas@gmail.com','$2y$10$CfJvBMxnsgSrNeDO8efJEOlpwaG3o0EhtdThlrgXYWpEsPErb4eoa','USUARIO');
INSERT INTO `Usuarios` (`idUsuarios`,`username`,`email`,`senha`,`tipo`) VALUES (5,'jessica','jessica@gmail.com','$2y$10$LVXibA6d6EX0/pnVHN1Zau95q1uX92nbUvq5GE1TLcVurZa2l7SyC','USUARIO');
INSERT INTO `Usuarios` (`idUsuarios`,`username`,`email`,`senha`,`tipo`) VALUES (6,'gabriela','gabriela@gmail.com','$2y$10$jhtrq.yjAxCEASsf70iRLu.iQs8AMADEJa.nMyeQDfiht3RWGzJUy','USUARIO');

INSERT INTO `Livros` (`idLivros`,`idUsuarios`,`idGeneros`,`caminhoCover`,`titulo`,`tituloOriginal`,`editora`,`autor`,`anoPublicacao`,`paginas`,`sinopse`,`aboutAutor`,`visitas`,`status`) VALUES (1,1,6,'cover.jpg','Silo','Wool','Intrínseca','Hugh Howey','2014',512,'Em uma paisagem destruída e hostil, em um futuro ao qual poucos tiveram o azar de sobreviver, uma comunidade resiste, confinada em um gigantesco silo subterrâneo. Lá dentro, mulheres e homens vivem enclausurados, sob regulamentos estritos, cercados por segredos e mentiras.\r\nPara continuar ali, eles precisam seguir as regras, mas há quem se recuse a fazer isso. Essas pessoas são as que ousam sonhar e ter esperança, e que contagiam os outros com seu otimismo. Um crime cuja punição é simples e mortal. Elas são levadas para o lado de fora. Juliette é uma dessas pessoas. E talvez seja a última.','Hugh Howey nasceu em 1975, na Carolina do Norte. Passou anos morando em um barco e, mais tarde, na função de capitão de iate. Ele escreveu Silo enquanto trabalhava em uma livraria, dedicando ao manuscrito suas manhãs e horas de almoço ao longo de quase três anos.','0','Disponivel');
INSERT INTO `Livros` (`idLivros`,`idUsuarios`,`idGeneros`,`caminhoCover`,`titulo`,`tituloOriginal`,`editora`,`autor`,`anoPublicacao`,`paginas`,`sinopse`,`aboutAutor`,`visitas`,`status`) VALUES (2,1,7,'cover[1].jpg','O Mochileiro das Galáxias','The Hitchhiker-39s Guide to the Galaxy','Arqueiro','Douglas Adams','2016',672,'Pela primeira vez, reunimos em um único volume os cinco livros da cultuada série O Mochileiro das Galáxias, de Douglas Adams.  Com mais de 15 milhões de exemplares vendidos, a saga do britânico esquisitão Arthur Dent pela Galáxia conquistou leitores do mundo inteiro. O humor ácido e as tramas surreais de Douglas Adams se tornaram ícones de uma geração e seguem fascinando – e divertindo – leitores de todas as idades. Pegue sua toalha, embarque nessa aventura improvável e, é claro, não entre em pânico!  O Guia do Mochileiro das Galáxias Segundos antes de a Terra ser destruída para dar lugar a uma via expressa interespacial, Arthur Dent é salvo por Ford Prefect, um E.T. que fazia pesquisa de ca','Douglas Adams é autor da famosa série O mochileiro das galáxias, cujos títulos incluem O guia dos mochileiros das galáxias, O restaurante no fim do universo, A vida, o universo e tudo mais, Até mais, e obrigado pelos peixes! e Praticamente inofensiva, todos publicados pela Arqueiro. Adams nasceu em Cambridge, Inglaterra, em 1952, e morreu aos 49 anos, em 2001.','0','Disponivel');
INSERT INTO `Livros` (`idLivros`,`idUsuarios`,`idGeneros`,`caminhoCover`,`titulo`,`tituloOriginal`,`editora`,`autor`,`anoPublicacao`,`paginas`,`sinopse`,`aboutAutor`,`visitas`,`status`) VALUES (3,1,6,'cover[2].jpg','O Lado bom da vida','Silver Linings Playbook','Intrínseca','Matthew Quick','2013',256,'Pat Peoples, um ex-professor de história na casa dos 30 anos, acaba de sair de uma instituição psiquiátrica. Convencido de que passou apenas alguns meses naquele “lugar ruim”, Pat não se lembra do que o fez ir para lá. O que sabe é que Nikki, sua esposa, quis que ficassem um &#34;tempo separados&#34;. Tentando recompor o quebra-cabeças de sua memória, agora repleta de lapsos, ele ainda precisa enfrentar uma realidade que não parece muito promissora. Com seu pai se recusando a falar com ele, sua esposa negando-se a aceitar revê-lo e seus amigos evitando comentar o que aconteceu antes de sua internação, Pat, agora um viciado em exercícios físicos, está determinado a reorganizar as coisas e rec','Matthew Quick (Filadélfia, 23 de outubro de 1973), é um autor americano de romances. É mais conhecido pelo livro Silver Linings Playbook. Além de &#34;O Lado Bom da Vida;, Matthew Quick também é autor de três outros romances,SORTA LIKE A ROCK STAR; (Quase Uma RockStar - Intrínseca 2015) de 2010 e ;BOY21; de 2012, não publicado no Brasil e ;FORGIVE ME, LEONARD PEACOCK; publicado aqui pela Intrínseca com o título &#34;Perdão, Leonard Peacock;. Quick nasceu e viveu os seus primeiros anos na Filadélfia, Pensilvânia. Após algum tempo se mudou para Oakly.','30','Disponivel');
INSERT INTO `Livros` (`idLivros`,`idUsuarios`,`idGeneros`,`caminhoCover`,`titulo`,`tituloOriginal`,`editora`,`autor`,`anoPublicacao`,`paginas`,`sinopse`,`aboutAutor`,`visitas`,`status`) VALUES (4,1,6,'cover[3].jpg','Cinquenta Tons de Cinza','Fifty Shades of Grey','Intrínseca','E. L. James','2012',480,'Quando Anastasia Steele entrevista o jovem empresário Christian Grey, descobre nele um homem atraente, brilhante e profundamente dominador. Ingênua e inocente, Ana se surpreende ao perceber que, a despeito da enigmática reserva de Grey, está desesperadamente atraída por ele. Incapaz de resistir à beleza discreta, à timidez e ao espírito independente de Ana, Grey admite que também a deseja — mas em seus próprios termos.','Erika Leonard James (7 de março de 1963), melhor conhecida pelo pseudônimo E.L. James, é uma escritora britânica, autora do bestseller erótico Cinquenta Tons de Cinza (no Brasil) ou As Cinquenta Sombras de Grey (em Portugal) (Fifty Shades of Grey).[1] Em 2012 foi considerada pela revista Time umas das 100 pessoas mais influentes do mundo. Já em 2013, entrou para a lista das 100 celebridades mais poderosas da revista Forbes','0','Disponivel');
INSERT INTO `Livros` (`idLivros`,`idUsuarios`,`idGeneros`,`caminhoCover`,`titulo`,`tituloOriginal`,`editora`,`autor`,`anoPublicacao`,`paginas`,`sinopse`,`aboutAutor`,`visitas`,`status`) VALUES (5,1,7,'cover[4].jpg','Divergente, Uma Escolha Pode Te Transformar(L1)','Divergent','Rocco','Veronica Roth','2012',504,'Numa Chicago futurista, a sociedade se divide em cinco facções – Abnegação, Amizade, Audácia, Franqueza e Erudição – e não pertencer a nenhuma delas é como ser invisível. Primeiro volume de uma bem-sucedida série de distopia – segmento em alta no mercado editorial juvenil desde o sucesso Jogos Vorazes – Divergente, romance de estreia de Veronica Roth, tem como protagonista uma jovem em embate com suas próprias escolhas. Um dos lançamentos mais aguardados do ano pelos jovens brasileiros, o livro está no topo da lista dos mais vendidos do The New York Times.','Veronica Roth é uma autora de sucesso internacional. Divergente, o primeiro título desta trilogia, alcançou o primeiro lugar dos mais vendidos do New York Times. Atualmente, ela mora em Chicago, nos Estados Unidos.','50','Disponivel');
INSERT INTO `Livros` (`idLivros`,`idUsuarios`,`idGeneros`,`caminhoCover`,`titulo`,`tituloOriginal`,`editora`,`autor`,`anoPublicacao`,`paginas`,`sinopse`,`aboutAutor`,`visitas`,`status`) VALUES (6,1,1,'cover[5].jpg','A Batalha do Apocalipse: Da queda dos anjos a','A Batalha do Apocalipse: Da queda dos anjos a','Verus','Eduardo Spohr','2010',588,'Há muitos e muitos anos, tantos quanto o número de estrelas no céu, o paraíso celeste foi palco de um terrível levante. Um grupo de anjos guerreiros, amantes da justiça e da liberdade, desafiou a tirania dos poderosos arcanjos, levantando armas contra seus opressores. Expulsos, os renegados foram forçados ao exílio e condenados a vagar pelo mundo dos homens até o Dia do Juízo Final. Mas eis que chega o momento do Apocalipse, o tempo do ajuste de contas. Único sobrevivente do expurgo, Ablon, o líder dos renegados, é convidado por Lúcifer, o Arcanjo Negro, a se juntar às suas legiões na Batalha do Armagedon, o embate final entre o céu e o inferno, a guerra que decidirá não só o destino do mund','Eduardo Spohr nasceu em junho de 1976, no Rio de Janeiro. Filho de pilotos de aviões e de uma comissária de bordo, teve a oportunidade de viajar pelo mundo, conhecendo culturas e povos diferentes. A paixão pela literatura e o fascínio pelo estudo da história o levaram a cursar comunicação social. Começou a trabalhar em agências de publicidade, mas acabou, gradualmente, migrando para o jornalismo. Hoje, além de criar projetos gráficos, é consultor de roteiro e ministra o curso “Estrutura literária: a jornada do herói no cinema e na literatura”, nas Faculdades Hélio Alonso (Facha), do Rio de Janeiro','10','Disponivel');
INSERT INTO `Livros` (`idLivros`,`idUsuarios`,`idGeneros`,`caminhoCover`,`titulo`,`tituloOriginal`,`editora`,`autor`,`anoPublicacao`,`paginas`,`sinopse`,`aboutAutor`,`visitas`,`status`) VALUES (7,1,6,'cover[6].jpg','Ordem(L2)','Order','Intrínseca','Hugh Howey','2015',512,'E se a sobrevivência dos seres humanos dependesse do deslocamento de milhares de cidadãos para uma enorme cidade subterrânea, com gigantescas telas de TV transmitindo imagens desoladoras do mundo do lá fora, e ninguém fosse autorizado a sair?\r\nEsse é a história de Silo, a série escrita por Hugh Howey que desbancou Guerra dos Tronos na lista de livros de ficção científica mais vendidos na Amazon.com. No primeiro livro da trilogia, a heroína era Juliette, uma operária nascida nos subterrâneos do bunker. Nesse segundo volume, Ordem, a história volta a um período anterior, explicando como o mundo de Juliette foi transformado. O livro revela as decisões, tomadas por alguns poucos poderosos, que f','Hugh Howey participou, em 2014, da Bienal do Livro de São Paulo.','0','Disponivel');
INSERT INTO `Livros` (`idLivros`,`idUsuarios`,`idGeneros`,`caminhoCover`,`titulo`,`tituloOriginal`,`editora`,`autor`,`anoPublicacao`,`paginas`,`sinopse`,`aboutAutor`,`visitas`,`status`) VALUES (8,1,10,'cover[7].jpg','A Garota no trem','The Girl on the Train','Record','Paula Hawkins','2015',378,'Um thriller psicológico que vai mudar para sempre a maneira como você observa a vida das pessoas ao seu redor Todas as manhãs Rachel pega o trem das 8h04 de Ashbury para Londres. O arrastar trepidante pelos trilhos faz parte de sua rotina. O percurso, que ela conhece de cor, é um hipnotizante passeio de galpões, caixas d’água, pontes e aconchegantes casas. Em determinado trecho, o trem para no sinal vermelho. E é de lá que Rachel observa diariamente a casa de número 15. Obcecada com seus belos habitantes – a quem chama de Jess e Jason –, Rachel é capaz de descrever o que imagina ser a vida perfeita do jovem casal. Até testemunhar uma cena chocante, segundos antes de o trem dar um solavanco e','Por volta de 2009, Hawkins começou a escrever comédia romântica de ficção sob o pseudônimo de Amy Silver, tendo escrito quatro romances, incluindo Confessions of a Reluctant Recessionista. Ela não conseguiu nenhum sucesso comercial até desafiar a si mesma a escrever uma história mais adulta e séria. Seu best-seller The Girl on the Train (2015) é um complexo thriller, com temas de violência doméstica, abuso de álcool e abuso de drogas. Em 2016, foi selecionada pela BBC como uma das 100 Mulheres mais importantes do ano.','20','Disponivel');
INSERT INTO `Livros` (`idLivros`,`idUsuarios`,`idGeneros`,`caminhoCover`,`titulo`,`tituloOriginal`,`editora`,`autor`,`anoPublicacao`,`paginas`,`sinopse`,`aboutAutor`,`visitas`,`status`) VALUES (9,1,1,'cover[8].jpg','A Sociedade do Anel - Volume 1. Série O Senho','The Fellowship of the Ring - Lord of the Ring','Martins Fontes','J. R. R. Tolkien','2000',464,'Numa cidadezinha indolente do Condado, um jovem hobbit é encarregado de uma imensa tarefa. Deve empreender uma perigosa viagem através da Terra-média até as Fendas da Perdição, e lá destruir o Anel do Poder - a única coisa que impede o domínio maléfico do Senhor do Escuro.','J.R.R. TOLKIEN nasceu a 3 de janeiro de 1892em Bloemfontein. Após servir na Primeira Guerra Mundial, Tolkien empreendeu uma notável carreira acadêmica e foi reconhecido como um dos maiores filólogos do mundo. No entanto, ele é mais conhecido como criador da Terra Média e autor de obras de ficção clássicas e extraordinárias como O Hobbit, O Senhor dos Anéis e O Silmarillion. Seus livros foram traduzidos para mais de 40 línguas e venderam muitos milhões de exemplares no mundo todo. Ele recebeu o título de CBE [Comandante da Ordem do Império Britânico], e um doutorado honorário em Letras da Unive','0','Disponivel');
INSERT INTO `Livros` (`idLivros`,`idUsuarios`,`idGeneros`,`caminhoCover`,`titulo`,`tituloOriginal`,`editora`,`autor`,`anoPublicacao`,`paginas`,`sinopse`,`aboutAutor`,`visitas`,`status`) VALUES (10,1,10,'cover[9].jpg','Seis anos depois','Six Years','Arqueiro','Harlan Coben','2014',272,'Library Journal Jake Fisher e Natalie Avery se conheceram no verão. Eles estavam em retiros diferentes, porém próximos um do outro. O dele era para escritores; o dela, para artistas. Eles se apaixonaram e, juntos, viveram os melhores meses de suas vidas. E foi por isso que Jake não entendeu quando Natalie decidiu romper com ele e se casar com Todd, um ex-namorado. No dia do casamento, ela pediu a Jake que os deixasse em paz e nunca mais voltasse a procurá-la. Jake tentou esconder seu coração partido dedicando-se integralmente à carreira de professor universitário e assim manteve sua promessa... durante seis anos. Ao ver o obituário de Todd, Jake não resiste e resolve se reaproximar de Natali','Harlan Coben é autor de Refúgio e Uma questão de segundos, da série de Mickey Bolitar, Fique comigo, Confie em mim, Não conte a ninguém, Desaparecido para sempre e Cilada e dos livros protagonizados por Myron Bolitar – Quebra de confiança, Jogada mortal, Sem deixar rastros, O preço da vitória, Quando ela se foi e Alta tensão (Arqueiro) –, além de A promessa, Silêncio na floresta, Não há segunda chance e O inocente (Arx). Esses dois últimos serão relançados pela Arqueiro. Vencedor de diversos prêmios, é o único escritor a ter recebido a trinca de ases da literatura policial americana: o Anthony','0','Disponivel');

INSERT INTO `Livros_Tags` (`idLivros_Tags`,`idLivros`,`idTags`) VALUES (1,2,2);
INSERT INTO `Livros_Tags` (`idLivros_Tags`,`idLivros`,`idTags`) VALUES (2,2,13);
INSERT INTO `Livros_Tags` (`idLivros_Tags`,`idLivros`,`idTags`) VALUES (3,3,3);
INSERT INTO `Livros_Tags` (`idLivros_Tags`,`idLivros`,`idTags`) VALUES (4,3,5);
INSERT INTO `Livros_Tags` (`idLivros_Tags`,`idLivros`,`idTags`) VALUES (5,3,11);
INSERT INTO `Livros_Tags` (`idLivros_Tags`,`idLivros`,`idTags`) VALUES (6,4,3);
INSERT INTO `Livros_Tags` (`idLivros_Tags`,`idLivros`,`idTags`) VALUES (7,4,5);
INSERT INTO `Livros_Tags` (`idLivros_Tags`,`idLivros`,`idTags`) VALUES (8,4,16);
INSERT INTO `Livros_Tags` (`idLivros_Tags`,`idLivros`,`idTags`) VALUES (9,5,8);
INSERT INTO `Livros_Tags` (`idLivros_Tags`,`idLivros`,`idTags`) VALUES (10,5,18);
INSERT INTO `Livros_Tags` (`idLivros_Tags`,`idLivros`,`idTags`) VALUES (11,6,14);
INSERT INTO `Livros_Tags` (`idLivros_Tags`,`idLivros`,`idTags`) VALUES (12,6,15);
INSERT INTO `Livros_Tags` (`idLivros_Tags`,`idLivros`,`idTags`) VALUES (13,6,20);
INSERT INTO `Livros_Tags` (`idLivros_Tags`,`idLivros`,`idTags`) VALUES (14,6,24);
INSERT INTO `Livros_Tags` (`idLivros_Tags`,`idLivros`,`idTags`) VALUES (15,7,14);
INSERT INTO `Livros_Tags` (`idLivros_Tags`,`idLivros`,`idTags`) VALUES (16,7,15);
INSERT INTO `Livros_Tags` (`idLivros_Tags`,`idLivros`,`idTags`) VALUES (17,7,24);
INSERT INTO `Livros_Tags` (`idLivros_Tags`,`idLivros`,`idTags`) VALUES (18,7,26);
INSERT INTO `Livros_Tags` (`idLivros_Tags`,`idLivros`,`idTags`) VALUES (19,8,3);
INSERT INTO `Livros_Tags` (`idLivros_Tags`,`idLivros`,`idTags`) VALUES (20,8,7);
INSERT INTO `Livros_Tags` (`idLivros_Tags`,`idLivros`,`idTags`) VALUES (21,8,23);
INSERT INTO `Livros_Tags` (`idLivros_Tags`,`idLivros`,`idTags`) VALUES (22,9,2);
INSERT INTO `Livros_Tags` (`idLivros_Tags`,`idLivros`,`idTags`) VALUES (23,9,8);
INSERT INTO `Livros_Tags` (`idLivros_Tags`,`idLivros`,`idTags`) VALUES (24,9,16);
INSERT INTO `Livros_Tags` (`idLivros_Tags`,`idLivros`,`idTags`) VALUES (25,9,18);
INSERT INTO `Livros_Tags` (`idLivros_Tags`,`idLivros`,`idTags`) VALUES (26,10,3);
INSERT INTO `Livros_Tags` (`idLivros_Tags`,`idLivros`,`idTags`) VALUES (27,10,4);
INSERT INTO `Livros_Tags` (`idLivros_Tags`,`idLivros`,`idTags`) VALUES (28,10,11);
INSERT INTO `Livros_Tags` (`idLivros_Tags`,`idLivros`,`idTags`) VALUES (29,10,22);
INSERT INTO `Livros_Tags` (`idLivros_Tags`,`idLivros`,`idTags`) VALUES (30,10,26);
INSERT INTO `Livros_Tags` (`idLivros_Tags`,`idLivros`,`idTags`) VALUES (31,10,27);

INSERT INTO `Comentarios` (`idComentarios`,`idUsuarios`,`idLivros`,`texto`,`data`,`aceito`) VALUES (1,1,1,'Parabens, otimo, muito bom, eu vi exatamente o quea chei que ia acontecer, inesperadamente, dependendo do óbvio, exatamente como ocorreu','2018-10-03','SIM');
INSERT INTO `Comentarios` (`idComentarios`,`idUsuarios`,`idLivros`,`texto`,`data`,`aceito`) VALUES (2,3,2,'meio exagerado, mas gostei bastante, exatamente como me recomendaram, parabens pelo site','2018-10-05','SIM');
INSERT INTO `Comentarios` (`idComentarios`,`idUsuarios`,`idLivros`,`texto`,`data`,`aceito`) VALUES (3,2,1,'Realmente, não gostei, achei meio cliche, parecia até os meus contos, se soubesse que era assim nem tinha baixado.','2018-10-05','SIM');
INSERT INTO `Comentarios` (`idComentarios`,`idUsuarios`,`idLivros`,`texto`,`data`,`aceito`) VALUES (4,6,3,'nunca achei que fosse acontecer aquilo, parecia até uma brincadeira, nunca pude imaginar que o protagonista morre','2018-10-05','Espera');
INSERT INTO `Comentarios` (`idComentarios`,`idUsuarios`,`idLivros`,`texto`,`data`,`aceito`) VALUES (5,4,4,'diferente do que já li até hoje, sem contar no romance que não foi nem um pouco cliche','2018-10-03','Espera');
INSERT INTO `Comentarios` (`idComentarios`,`idUsuarios`,`idLivros`,`texto`,`data`,`aceito`) VALUES (6,4,2,'o protagonista age de formas diferentes o tempo todo, o escritor tinha um problema em relação a personalidade de seu protagonista','2018-10-02','SIM');
INSERT INTO `Comentarios` (`idComentarios`,`idUsuarios`,`idLivros`,`texto`,`data`,`aceito`) VALUES (7,6,3,'é dificil imaginar este livro fazendo sucesso sem que tenham feito algum tipo de pacto, eu nunca achei que veria algo assim nos famosos','2018-10-02','SIM');
INSERT INTO `Comentarios` (`idComentarios`,`idUsuarios`,`idLivros`,`texto`,`data`,`aceito`) VALUES (8,6,2,'mal posso esperar pra ler todas as páginas do próximo volume, é meu sonho terminar meu primeiro livro','2018-10-04','Espera');
INSERT INTO `Comentarios` (`idComentarios`,`idUsuarios`,`idLivros`,`texto`,`data`,`aceito`) VALUES (9,1,5,'não aguento mais escrever comentários aleatórios para testar esse site, eu já posso ver todos esses comentários sendo negados por mim mesmo','2018-10-04','SIM');
INSERT INTO `Comentarios` (`idComentarios`,`idUsuarios`,`idLivros`,`texto`,`data`,`aceito`) VALUES (10,2,2,'vou copiar e colar alguns, será que alguém vai perceber, não sei,melhor fazer tudo mesmo, falta só uns 10, vou inventar algo','2018-10-06','SIM');
INSERT INTO `Comentarios` (`idComentarios`,`idUsuarios`,`idLivros`,`texto`,`data`,`aceito`) VALUES (11,4,3,'dependendo da suposição existente contra curricular abstraindo-se do fato onde se negue a própria existencia, concluo que ','2018-10-02','Espera');
INSERT INTO `Comentarios` (`idComentarios`,`idUsuarios`,`idLivros`,`texto`,`data`,`aceito`) VALUES (12,4,6,'esse negócio de acabar caractéres é muito perigoso, um dia desse estava eu lendo um comentário do meu livro favorito onde vi um spoiler que dizia que o protagonista...','2018-10-04','Espera');
INSERT INTO `Comentarios` (`idComentarios`,`idUsuarios`,`idLivros`,`texto`,`data`,`aceito`) VALUES (13,4,5,'os downloads 1  e 2 não estão funcionando, parece até que tem um erro nessa programação','2018-10-02','SIM');
INSERT INTO `Comentarios` (`idComentarios`,`idUsuarios`,`idLivros`,`texto`,`data`,`aceito`) VALUES (14,6,2,'parece que tem um código nessa gambiarra em, mal posso esperar pra tentar burlar o meu proprio sistema','2018-10-06','Espera');
INSERT INTO `Comentarios` (`idComentarios`,`idUsuarios`,`idLivros`,`texto`,`data`,`aceito`) VALUES (15,5,4,'naoseinao seinaoseinao seinaos einaosein aoseinaoseinao seinaoseinaosei naoseinaosei naosei11 11111','2018-10-02','SIM');
INSERT INTO `Comentarios` (`idComentarios`,`idUsuarios`,`idLivros`,`texto`,`data`,`aceito`) VALUES (16,5,8,'naosein aosein aose inao sein ose inaoseina osei aosein aoseinao seinaose inaoseina ose inaose i111111 1222','2018-10-06','Espera');
INSERT INTO `Comentarios` (`idComentarios`,`idUsuarios`,`idLivros`,`texto`,`data`,`aceito`) VALUES (17,6,7,'naosei naoseina  seinaoseina osei naos aoseinao seinaos einaoseinao seinaos einaose in aos ei11 1113 333','2018-10-02','SIM');
INSERT INTO `Comentarios` (`idComentarios`,`idUsuarios`,`idLivros`,`texto`,`data`,`aceito`) VALUES (18,4,6,'naosei nao se in aosei na seinao se naose inao seinaos inaose inaos ei naos einaose inaos inaose i1111 1444','2018-10-07','Espera');
INSERT INTO `Comentarios` (`idComentarios`,`idUsuarios`,`idLivros`,`texto`,`data`,`aceito`) VALUES (19,3,3,'naose naos inaos in aosei nao sei naoseinaose inaose aoseinaosei naoseinaosein aoseinaose i11111555','2018-10-02','SIM');
INSERT INTO `Comentarios` (`idComentarios`,`idUsuarios`,`idLivros`,`texto`,`data`,`aceito`) VALUES (20,2,4,'Particularmente, deveria ter acababado no volume 1, mas defendo a ideia de um novo romance fluindo de personagens como estes.','2018-10-07','NAO');

INSERT INTO `Resenhas` (`idResenhas`,`idUsuarios`,`idLivros`,`titulo`,`texto`,`datepost`) VALUES (1,1,5,'achei uma porcaria','resenha.txt','2018-10-07 00:00:00');
INSERT INTO `Resenhas` (`idResenhas`,`idUsuarios`,`idLivros`,`titulo`,`texto`,`datepost`) VALUES (2,1,5,'achei bem loko','resenha[0].txt','2018-10-05 22:31:28');

INSERT INTO `Managers` (`idManagers`,`idUsuarios`,`titulo`,`autor`,`tamanhoEpub`,`caminhoEpub`,`nivel`) VALUES (1,4,'o lado bom da vida','matthew quick','350382KB','o lado bom da vida.epub','publico');
/*Precisa de mais Managers e Resenhas*/

INSERT INTO `Destaques` (`idDestaques`,`idLivros`,`dataTrocar`) VALUES (1,'4','2018-10-24');