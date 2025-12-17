-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2025 at 02:17 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trailguide`
--

-- --------------------------------------------------------

--
-- Table structure for table `alerts`
--

CREATE TABLE `alerts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `severity` enum('LOW','MEDIUM','HIGH') NOT NULL,
  `type` varchar(100) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `alt_route` text DEFAULT NULL,
  `proof` varchar(255) DEFAULT NULL,
  `approved` enum('pending','approved','denied') NOT NULL DEFAULT 'pending',
  `place_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alerts`
--

INSERT INTO `alerts` (`id`, `title`, `description`, `location`, `date`, `severity`, `type`, `status`, `alt_route`, `proof`, `approved`, `place_id`) VALUES
(1, 'Landslide alert', 'Hi trekkers. Please be aware of the landslide and flood. Due to continuous rainfall from yesterday (july 5) the road from Dumre to Besisahar has been disturbed due to landslide. Somehow the road has been opened one way. From Besisahar onwards, there are many landslides and the road and the trialhead has been disturbed. Please postpone your trek for few days or travel after only getting proper information about the way and trialhead. ', 'Besisahar', '2025-07-05', 'HIGH', 'Landslide(road block)', 'active', '', 'uploads/1753419497_landslide.jpg', 'approved', '25'),
(4, 'Glacier Alert', 'Trekkers have gone missing from the area between Lobuche to Gorak Shep in the off season. It’s highly probably this is due to getting lost due to glacier movement in this area which changes the trail. As nobody in the area puts up new signs until the end of the monsoon season it is highly advised to go with a guide during the off season to avoid getting lost.\r\n\r\nFor your own safety please take a guide during the off season and peak season as it is obvious this area changes to such a degree that it’s causing people to become lost and tragically go missing. As a result of this it is also causing the knock on effect of limiting independent trekking in the region for others during the peak seasons.', 'Lobuche', '2025-07-02', 'MEDIUM', 'Glacier Melt', 'active', '', 'uploads/1753419945_glacier.jpg', 'approved', '36'),
(6, 'Bad weather in Manaslu', 'Based on recent history and eyewitness accounts, the Manaslu trekking circuit is currently experiencing hazardous weather conditions. In prior seasons, trekkers and climbers reported heavy monsoon rainfall and sudden snowstorms near Larkya La Pass (≈ 5,160 m), causing trail blockages, near‑freezing wet snow, avalanches, and continuous fog', 'Larkya La', '2025-07-11', 'MEDIUM', 'Bad Weather', 'active', '', 'uploads/1753420752_manaslu.jpg', 'approved', '51');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `postId` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `content` text NOT NULL,
  `parent` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `postId`, `userid`, `content`, `parent`) VALUES
(1, 4, 3, 'Hi there, Ghorepani-Poonhill is extremely accessible as a beginner friendly trek and virtually no risk of high altitude sickness due to its lower elevation.\r\n\r\nEnd of February is ideal due to late Winter and Early Spring weather. The temperature wouldn&#039;t be too low but still cold paired with clear weather (generally). This time also attracts fairly low no. of trekkers so less crowd and more peaceful trails. Your general itinerary could look like this:\r\n\r\nDay 1 - Pokhara to Ghandruk via Jeep or Bus Day 2 - Ghandruk to Tadhapani Day 3 - Tadhapani to Ghorepani Day 4 - Early morning hike to Poonhill and Trek to Banthati after Breakfast and Jeep out to Pokhara Day 5 - Exploration Day at Pokhara Day 6 - Pokhara to Kathmandu via Flight or Tourist Bus Day 7 - Fly out from Kathmandu\r\n\r\nHowever, this itinerary can be done from other way around which makes sense if you want to trek to Chomrong and Jhinu Hot Springs. Only ACAP permit is required which is available from Nepal Tourism Board Office Pokhara or Kathmandu. The itinerary that I have shared doesn&#039;t include traversing over Suspension bridge so you can rest easy on this one. For cost, it might fall on the range of 300 USD including:\r\n\r\nACAP Fees\r\n\r\nGuide and (1) Porter Fees for 4 days\r\n\r\nPrivate Jeep Transportation from Pokhara to Ghandruk and Banthati to Pokhara\r\n\r\nThe above mentioned cost doesn&#039;t include Food and Accomodation and what you calculated makes sense for average cost per meal.\r\n\r\nFinally, there are options to extend the trek upto Mohare Danda - Nangi - Baskharka which can have additional 3-4 days for the existing trek and have more chances of viewing the mountains. Also, instead of ending at Ghorepani-Banthati, we can deviate towards Tatopani and actually recover on the hotsprings over there and travel back to Pokhara.\r\n\r\nHope it helps for your planning. On the end, porter/guide would be less experienced than your Guide for the guiding related services with limited or no knowledge of Wilderness First Aid, Risk Management, Communication Barrier, etc and hence the low prices as Porter/Guide would be on your aid to carry your luggage and navigation only.', 0),
(2, 1, 6, 'Thank you for your response and tips.  I am thinking Poon Hill trek 4 Days / 3 nights.  I have a 50L bag. Is it too big ? https://www.llbean.ca/shop/Mens-L.L.Bean-Ridge-Runner-Backpack-50L/127647.html it isnt water proof though, is that a problem? I seen videos of those ppl trekking this circuit, their bag seems a lot smaller looks slightly bigger than a backpack, except the guide. The guide’s bag is usually very very big / fat like x3 times fatter, like round. Is bringing a big bag 50L bad idea ?  I thought can take a public bus from Pokhara to Nayapan / near Birethani. 500 ruppes (both, the guide could get us local price). Am still thinking atm, just the guide and me, no need to get a jeep. I need someone who will be chatty or I could be bored. I saw random video …of trekking hiking through nepalese villages, the local nepalese rural villages can speak foreign lanngagues like Korean language, Malaysia, other Asian/South East Asian/ Middle East etc… I was a bit surprised. Then they said they previously worked in those countries for several years, learnt the language, and came back to Nepal. They did not explain why they came back to Nepal, maybe working visa expired, they earned enough money, come back home, get married settled down in Nepal, maybe due to covid, borders shut, many had to return back to their country, etc….is it easy to find a Guide who has travelled overseas and worked in a foreign country, understand foreign culture, a broader cultural expose ….who we have more stuffs to talk about, more similar interests etc… rather than just a Guide who has never been out of Nepal, sure I wanna know about Nepali culture, history, traditions, but might be also easier if they can easily be the bridge, help me to relate to Nepal better. Are these Guide with overseas exposure quite rare ?  Go clockwise… then do a short detour to Jhinu Hot Spring on the last day, I saw its a small pool, but not crowded, a short dip/ breaktime. I saw the other one, Tatopani, bigger, can get crowded, popular with locals too, saw people travelling there by bus. Do they trek back to Nayapan or they go to Ghandruk, take the bus back to Pokhara ? Because its going down hill….Jhinun Hot Spring to Nayapan, doubt there will be any nice views ? Might as well go to Ghandruk take the bus back to Pokhara ? Am I right ?  Do you have a sample packing list for the trek ? It is not going to snow right/ice. You dont need any ice shoes right ? I wonder if can fit everything in a Jansport backpack. I been told those lodges will not have heating in the room, there might be a fire place in the common area, bring more winter clothings. Is a sleeping bag recommended ? I do want a hiking stick, do I need two (right and left, i think i saw video, most ppl just use one, maybe the other hand for camera), or just one will do…i saw one in my local shop very expensive during sale….equivalent to 15,000 rupees 😱, i also saw there are traditional Nepali stick, do tourist use them ? If I need to buy hiking gears,….is it better to buy/rent in Katmandu (Thamel) or buy/rent in from Pokhara …  In February is leeches a problem?  I was checking prices of booking.com for accomodation. It seems booking accomodation far ahead of time Feb 2025 cost more…. I checked that even booking for peak season (October) accomodation pokhara is cheaper than booking off peak season Feb 2025. Feb 2025 is x2-x3 price. Does it mean its better to just turn up…. and do last minute booking for accomodation ? Off peak season, probably could get cheaper prices.  What do you think about Mardi Himal compared to Poon Hill ?', 1),
(3, 5, 2, 'Wow, really love that you liked visiting our Country!\r\nNepal is not that well popular but you will know when you step foot here that it truly is beautiful', 0),
(4, 1, 2, 'such a magnificent view, it surely must have been a pleasant experience, i would also love to visit this place soon.', 0),
(5, 6, 1, 'Hey! T too am planning to go there with my fiancee how much did it cost you?', 0),
(6, 5, 7, 'It costed nearly 2 lakhs for me to complete the whole trek, the prices may vary according to agencies though.', 1),
(7, 3, 3, 'haha\r\n', 0);

-- --------------------------------------------------------

--
-- Table structure for table `hidden_gems`
--

CREATE TABLE `hidden_gems` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `approved` enum('pending','approved','denied') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE `places` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `places`
--

INSERT INTO `places` (`id`, `name`) VALUES
(1, 'kathmandu'),
(2, 'pokhara'),
(3, 'bhaktapur'),
(4, 'lalitpur'),
(5, 'chitwan'),
(6, 'lumbini'),
(7, 'dharan'),
(8, 'janakpur'),
(9, 'biratnagar'),
(10, 'nepalgunj'),
(11, 'lukla'),
(12, 'namche bazaar'),
(13, 'tengboche'),
(14, 'dingboche'),
(15, 'lobuche'),
(16, 'gorak shep'),
(17, 'everest base camp'),
(18, 'gokyo'),
(19, 'jomsom'),
(20, 'muktinath'),
(21, 'ghorepani'),
(22, 'poon hill'),
(23, 'tatopani'),
(24, 'ghandruk'),
(25, 'annapurna base camp'),
(26, 'mardi himal'),
(27, 'manang'),
(28, 'pisang'),
(29, 'thorong la pass'),
(30, 'phakding'),
(31, 'gorakshep'),
(32, 'chhomrong'),
(33, 'syabrubesi'),
(34, 'langtang village'),
(35, 'kyanjin gompa'),
(36, 'solokhumbhu'),
(37, 'bhimtang'),
(38, 'dharapani'),
(39, 'talcha'),
(40, 'rara lake'),
(41, 'tikhedhunga'),
(42, 'silgadhi'),
(43, 'dhangadhi'),
(44, 'khaptad'),
(45, 'kagbeni'),
(46, 'lo manthang'),
(47, 'manaslu circuit'),
(48, 'khaptad national park'),
(49, 'upper mustang'),
(50, 'rara national park'),
(51, 'gorkha');

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` int(11) NOT NULL,
  `origin` int(11) NOT NULL,
  `destination` int(11) NOT NULL,
  `permits` text NOT NULL,
  `guide` tinyint(1) NOT NULL DEFAULT 0,
  `guide_fee` varchar(20) DEFAULT NULL,
  `season` text NOT NULL,
  `level` varchar(20) NOT NULL,
  `altitude` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `origin`, `destination`, `permits`, `guide`, `guide_fee`, `season`, `level`, `altitude`, `status`) VALUES
(1, 1, 24, '[\"TIMS\",\"ACAP\"]', 0, '', 'Spring,Autumn', 'Easy', 2012, 0),
(2, 1, 17, '[\"TIMS\",\"Sagarmatha National Park\"]', 2, '3500', 'Spring,Autumn', 'Hard', 5364, 0),
(3, 1, 25, '[\"TIMS\",\"ACAP\"]', 1, '3000', 'Spring,Autumn', 'Medium', 4130, 0),
(4, 1, 34, '[\"TIMS\",\"Langtang National Park\"]', 0, '', 'Spring,Autumn,Winter', 'Medium', 3870, 0),
(5, 1, 50, '[\"TIMS\",\"Rara National Park\"]', 1, '3000', 'Autumn,Winter', 'Medium', 2990, 0),
(6, 43, 48, '', 0, '', 'Spring,Autumn', 'Easy', 3276, 0),
(7, 1, 49, '[\"ACAP\",\"Restricted Area Permit\"]', 2, '3500', 'Spring,Summer,Autumn', 'Medium', 3810, 0);

-- --------------------------------------------------------

--
-- Table structure for table `populars`
--

CREATE TABLE `populars` (
  `id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `populars`
--

INSERT INTO `populars` (`id`, `plan_id`, `name`) VALUES
(1, 1, 'Kathmandu to Ghandruk'),
(2, 2, 'Kathmandu to Everest Base Camp'),
(3, 3, 'Kathmandu to Annapurna Base Camp'),
(4, 4, 'Kathmandu to Langtang Village'),
(5, 5, 'Kathmandu to Rara National Park'),
(6, 6, 'Dhangadhi to Khaptad National Park'),
(7, 7, 'Kathmandu to Upper Mustang');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `content` text NOT NULL,
  `containsFile` tinyint(4) NOT NULL DEFAULT 0,
  `image` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `userid`, `content`, `containsFile`, `image`) VALUES
(1, 5, 'I actually was travelling shivapuri national park and saw a really beautiful waterfall in the area so i thought to share with you guys. It was a awesome experience, excited to see more beautiful sites in Nepal', 1, 'uploads/1befd27a884de651547786cc.jpg'),
(2, 1, 'Hello! I am looking to trek Three Passes end of October or early November 2025. I am a solo teen traveler and would prefer a guide and porter as I don&#039;t have high altitude experience despite being fit. I have contacted a few trekking companies online that offer group packages. Time is not an issue, if I need to stay an extra day to acclimatize, I can. My fear with a group is that timelines must be more strictly followed and there is a possibility my trek cancelled if I need an extra day. Is this typically the case? What do you recommend? Thank you.', 0, ''),
(3, 5, 'I am actually planning to travel Nepal in few days, i plan to visit Everest base camp but heard that it is quite unsafe at the moment, can you guys suggest me when will it be good to visit the place?', 0, ''),
(4, 6, 'Hello. I starting to think/ plan for a solo trip to nepal. Budget traveller, i was thinking off season ….maybe February middle or should i aim for end Feb? Is it too cold ? I saw some youtube videos they did not say when in Feb… but it seems sunny, no snow…saw some ppl…hiking in T-shirt, they walking alot/exercising. I wonder if its because of global warming, winter gets shorter… i am trying to avoid March Holi, crowd…i saw some videos of peak season travelling, you need to wait and queue to take photos at the mountains…lol. That’s too many people for me. I was also hoping off season, maybe can be cheaper. So you think it wont be too crowded in Feb middle or Feb end ?\r\n\r\nAh i forgot to say, i am not going everest. At the moment, I only thinking of Kathamandu fly in, then to Pokhara. I am not sure what else is there, worthy to see or do. I am looking about 7 days or so in Nepal, not too long. Hoping it will be closeby.\r\n\r\nI am thinking of doing an easy trek for beginners. I did some hiking…but nothing too serious. The highest mountain I climb was only 1300m Mt Wellington. So an amateur at trekking. I am thinking to do Poon hill trek. Does all Poon Hill trek includes Jhinu Hot Springs ?\r\n\r\nI dont understand the price. I was thinking just an English speaking guide, no need porter. Is 4 days 3 nights recommended or 5 days 4 nights poon hill trek ? Does 5 days means…. More resting? Or different route ? I read the price of a guide is about USD $25-USD $30 per day. 4 days will be about USD $120. Then I heard usually accomodation is free, if you dine in. I saw the food is about 500 rupees per meal, dal bhat is more expensive at 780 rupees per meal. 500 rupees x 4 days x 2 people ( i assume you pay the guide’s meal as well) x 3 meals per day =12,000 rupees or USD $90. TIM card for solo trekker is 2,000 rupees or USD $15. Entrance fee to Annapurna 3000 rupees or USD 23. That’s $250…the you add aditional stuffs like transport, hot water, water, etc… am I missing anything ? The price seems vastly different from online quotes. I am talking more about the actual “trekking” costs itself…of course need to have the right gears, clothings, medications etc… The guide will have first aid kit ?\r\n\r\nDo people need to aclimitize for Poon Hill trek like….stay in Pokhara before the hike ? I dont anyone doing that…Pokhara is only 822m.\r\n\r\nWhy is the price of the porter-guide cheaper than a guide ? Thought a porter-guide is someone who will do both carry your bag and guide/talk/show you the way. Twice the job, but less money. How does a porter-guide carry your bag ? What about his own bag ?\r\n\r\nI heard about a lake in Pokhara, so I will go see that. I think sunset time. I am not doing paragliding, afraid of heights…. So, there is probably suspension bridges, how do your past clients afraid of height deal with that ? I was thinking ask the guide to walk in front, no sudden shaking, i will remove my prescription glasses and just follow him from behind, dont look down, 🫣.\r\n\r\nAny hidden gems or other interesting spots to explore ? Although I know it cant be guaranteed, but it will be really disappointing to hike 4 days in misty weather and cant see good views, or if it rains, i hope the weather will be decent in February. If its very cloudy, cant see a thing in Poon Hill, i dont want to move ….any options to be flexible and stay longer until I see some epic views ? Why do ppl move on so quickly to the next ….town, why dont ppl stay at one of the hotels/lodges and enjoy the views, recuperate. Which is why I thought Jhinu Hot Spring could be a good spot to relax a bit and recover.\r\n\r\nMany thanks', 0, ''),
(5, 5, 'I visited syambhunath temple today, it was a good experience, i had so much fun, awkward to hear but i also made friends to some of the monkeys, i would like to encourage every tourists who visit Nepal to visit this place once.', 1, 'uploads/22788e1eec4f99067cf00580.jpg'),
(6, 7, 'Just visited Mt. Everest Base Camp and it was just a wonderfull experience.\r\nI suggest everyone who love trekking to go there.', 1, 'uploads/2213125e1d76a2a9067db53c.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `place` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`id`, `plan_id`, `place`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 24),
(4, 2, 1),
(5, 2, 11),
(6, 2, 30),
(7, 2, 12),
(8, 2, 13),
(9, 2, 14),
(10, 2, 31),
(11, 2, 17),
(12, 3, 1),
(13, 3, 2),
(14, 3, 41),
(15, 3, 21),
(16, 3, 32),
(17, 3, 25),
(18, 4, 1),
(19, 4, 33),
(20, 4, 34),
(21, 4, 35),
(22, 5, 1),
(23, 5, 10),
(24, 5, 39),
(25, 5, 40),
(26, 6, 43),
(27, 6, 42),
(28, 6, 44),
(29, 7, 1),
(30, 7, 2),
(31, 7, 19),
(32, 7, 45),
(33, 7, 46);

-- --------------------------------------------------------

--
-- Table structure for table `sponsers`
--

CREATE TABLE `sponsers` (
  `id` int(11) NOT NULL,
  `HotelName` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `place` int(11) NOT NULL,
  `address` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sponsers`
--

INSERT INTO `sponsers` (`id`, `HotelName`, `message`, `place`, `address`) VALUES
(1, 'Ghandruk Village Eco Lodge', 'Free Wifi, Free ', 24, 'Ghandruk, Nepal'),
(2, 'Hotel Natural Spring Pvt.', 'free parking, free wifi', 24, 'Ghandruk, Nepal'),
(3, 'Nepal Paviion Inn', '42% than usual', 1, 'Thamel, Kathmandu'),
(4, 'Capital Botique Hotel', '50% than usual', 1, 'Lainchaur, Kathmandu'),
(5, 'Hotel Waterfall', 'waterfall hotel', 11, 'Lukla'),
(6, 'Hotel Sherpaland', 'special sherpa dishes', 12, 'Buspark, Namche Bazar'),
(7, 'Mountain View Lodge', 'enjoy food with best mountain views', 12, 'Namche Bazar');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(200) NOT NULL,
  `followed` text DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `FirstName`, `LastName`, `email`, `password`, `followed`, `admin`) VALUES
(1, 'John', 'Deo', 'bkishmat70@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', NULL, 1),
(2, 'Pasang', 'Sherpa', 'orgmediar@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL, 0),
(3, 'Rhythm', 'Bhattarai', 'rhythmbhattari90@gmail.com', '6144ace3d6141b30da844c6f7534e142', NULL, 1),
(4, 'Ronjal', 'Adhikari', 'ronjaladhikari@gmail.com', 'b4f869d6cb5eda96d3949b1a8ec9b6b0', NULL, 0),
(5, 'Mukesh', 'Singh', 'mukeshsingh@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', NULL, 0),
(6, 'Richard', 'Alison', 'richard@gmail.com', '59a1a1f4df715e6e209d1cf476845eb9', NULL, 0),
(7, 'Ronjal ', 'Adhikari', 'ronjal1@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '[\"3\"]', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alerts`
--
ALTER TABLE `alerts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `postId` (`postId`);

--
-- Indexes for table `hidden_gems`
--
ALTER TABLE `hidden_gems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `origin` (`origin`),
  ADD KEY `destination` (`destination`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `populars`
--
ALTER TABLE `populars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plan_id` (`plan_id`),
  ADD KEY `place` (`place`);

--
-- Indexes for table `sponsers`
--
ALTER TABLE `sponsers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alerts`
--
ALTER TABLE `alerts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `hidden_gems`
--
ALTER TABLE `hidden_gems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `places`
--
ALTER TABLE `places`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `populars`
--
ALTER TABLE `populars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `sponsers`
--
ALTER TABLE `sponsers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
