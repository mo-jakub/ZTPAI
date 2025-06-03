-- ----------------------------
-- View structure for Book_details
-- ----------------------------
CREATE VIEW book_details AS
SELECT
    b.id,                             -- Book identifier
    b.title,                               -- Book title
    b.description,                         -- Book description
    b.cover,                               -- Book cover image URL/path
    ARRAY_AGG(DISTINCT a.author) AS authors, -- List of authors for the book
    ARRAY_AGG(DISTINCT t.tag) AS tags,     -- List of tags for the book
    ARRAY_AGG(DISTINCT g.genre) AS genres  -- List of genres for the book
FROM
    books b
        LEFT JOIN book_authors ba ON b.id = ba.id_book -- Join with book_authors
        LEFT JOIN authors a ON ba.id_author = a.id   -- Join with authors
        LEFT JOIN book_tags bt ON b.id = bt.id_book    -- Join with book_tags
        LEFT JOIN tags t ON bt.id_tag = t.id            -- Join with tags
        LEFT JOIN book_genres bg ON b.id = bg.id_book  -- Join with book_genres
        LEFT JOIN genres g ON bg.id_genre = g.id      -- Join with genres
GROUP BY
    b.id, b.title, b.description;     -- Group data to ensure distinct results for each book

-- ----------------------------
-- Records of the Genres table
-- ----------------------------
INSERT INTO public.genres (genre) VALUES
    ('Fantasy'),
    ('Science Fiction'),
    ('Mystery'),
    ('Romance'),
    ('Horror'),
    ('Thriller'),
    ('Non-fiction'),
    ('Historical'),
    ('Adventure'),
    ('Biography');

-- ----------------------------
-- Records of the Books table
-- ----------------------------
INSERT INTO public.books (title, description, cover) VALUES
-- Fantasy Books
    ('The Hobbit', 'A hobbit embarks on an epic adventure to reclaim a mountain from a dragon', '/public/images/covers/679b772cb2570_hobbit.jpg'),
    ('Harry Potter and the Sorcerer''s Stone', 'A young wizard discovers his destiny at a magical school', '/public/images/covers/679b7c6d8af35_harry_potter_s_s.jpg'),
    ('The Name of the Wind', 'A gifted musician becomes a legendary figure in a dangerous world', NULL),
    ('A Game of Thrones', 'Noble families vie for power in a world of intrigue and dragons', NULL),
    ('Mistborn: The Final Empire', 'A street thief leads a rebellion against a tyrant with magical powers', NULL),
    ('The Way of Kings', 'Knights and storms shape a world of epic conflicts and prophecy', NULL),
    ('Good Omens', 'An angel and demon team up to prevent the apocalypse', NULL),
    ('The Lies of Locke Lamora', 'A cunning thief plots heists in a Venetian-inspired fantasy city', NULL),
    ('The Last Unicorn', 'A unicorn searches for her lost kin in a world of magic', NULL),
    ('The Witcher: The Last Wish', 'A monster hunter navigates moral dilemmas in a fantastical world', NULL),

-- Science Fiction Books
    ('Dune', 'A desert planet holds the key to interstellar power and survival', NULL),
    ('Neuromancer', 'A washed-up hacker is hired for a virtual heist in cyberspace', NULL),
    ('Foundation', 'A mathematician predicts the fall of an empire and plans its rebirth', NULL),
    ('Snow Crash', 'A hacker uncovers a conspiracy in a hyper-connected dystopia', NULL),
    ('Hyperion', 'Pilgrims share tales of a mysterious and deadly artifact', NULL),
    ('The Left Hand of Darkness', 'A diplomat navigates gender and politics on a distant planet', NULL),
    ('Ender''s Game', 'A boy genius trains to fight an alien threat in a war simulation', NULL),
    ('The War of the Worlds', 'Earth is invaded by Martians in a tale of survival and resistance', NULL),
    ('The Three-Body Problem', 'Earth contacts an alien civilization with unexpected consequences', NULL),
    ('Brave New World', 'A dystopian society shaped by technology, conditioning, and control', NULL),

-- Mystery Books
    ('The Girl with the Dragon Tattoo', 'A journalist and a hacker uncover dark secrets in a wealthy family', NULL),
    ('Gone Girl', 'A missing wife’s disappearance unravels a web of lies and deceit', NULL),
    ('The Da Vinci Code', 'A symbologist solves a murder linked to religious secrets', NULL),
    ('In the Woods', 'A detective investigates a murder tied to his own childhood trauma', NULL),
    ('Big Little Lies', 'Secrets and lies unravel in a seemingly perfect community', NULL),
    ('Sharp Objects', 'A reporter confronts her dark past while covering a small-town murder', NULL),
    ('The Silent Patient', 'A therapist seeks to uncover why a woman stopped speaking after a crime', NULL),
    ('The Hound of the Baskervilles', 'Sherlock Holmes investigates a legendary beast haunting a family', NULL),
    ('And Then There Were None', 'Strangers are stranded on an island and killed one by one', NULL),
    ('The Woman in the Window', 'An agoraphobic woman believes she witnessed a crime next door', NULL),

-- Romance Books
    ('Pride and Prejudice', 'A witty romance unfolds amid societal pressures and misunderstandings', NULL),
    ('The Notebook', 'A love story spanning decades, told through a man’s memories', NULL),
    ('Me Before You', 'A caregiver and a disabled man forge a life-changing bond', NULL),
    ('Outlander', 'A WWII nurse is transported to 18th-century Scotland and finds romance', NULL),
    ('Bridgerton: The Duke and I', 'A duke and a debutante fake a courtship but fall in love', NULL),
    ('Twilight', 'A teen girl falls for a mysterious vampire with a dangerous secret', NULL),
    ('The Hating Game', 'Office rivals discover a thin line between love and hate', NULL),
    ('Red, White & Royal Blue', 'A U.S. president’s son and a British prince fall in love', NULL),
    ('Beach Read', 'Two authors with writer’s block challenge each other to switch genres', NULL),
    ('People We Meet on Vacation', 'Two best friends reconnect on a life-changing trip', NULL),

-- Horror Books
    ('The Shining', 'A family’s stay in a haunted hotel descends into madness', NULL),
    ('Dracula', 'A vampire terrorizes England as a group tries to stop him', NULL),
    ('Frankenstein', 'A scientist creates life, leading to tragic consequences', NULL),
    ('It', 'A group confronts a shape-shifting monster haunting their town', NULL),
    ('The Haunting of Hill House', 'A paranormal investigation turns into a psychological nightmare', NULL),
    ('Pet Sematary', 'A family discovers the dark power of a burial ground', NULL),
    ('Bird Box', 'Survivors navigate a world where seeing monsters leads to death', NULL),
    ('The Exorcist', 'A priest battles to save a girl possessed by a demonic force', NULL),
    ('House of Leaves', 'A family discovers their house is larger inside than outside', NULL),
    ('The Silence of the Lambs', 'An FBI trainee seeks the help of a cannibalistic killer to catch another murderer', NULL);


-- ----------------------------
-- Records of the Book_Genres table
-- ----------------------------
INSERT INTO public.book_genres (id_book, id_genre) VALUES
-- Fantasy
    (1, 1), (2, 1), (3, 1), (4, 1), (5, 1),
    (6, 1), (7, 1), (8, 1), (9, 1), (10, 1),

-- Science Fiction
    (11, 2), (12, 2), (13, 2), (14, 2), (15, 2),
    (16, 2), (17, 2), (18, 2), (19, 2), (20, 2),

-- Mystery
    (21, 3), (22, 3), (23, 3), (24, 3), (25, 3),
    (26, 3), (27, 3), (28, 3), (29, 3), (30, 3),

-- Romance
    (31, 4), (32, 4), (33, 4), (34, 4), (35, 4),
    (36, 4), (37, 4), (38, 4), (39, 4), (40, 4),

-- Horror
    (41, 5), (42, 5), (43, 5), (44, 5), (45, 5),
    (46, 5), (47, 5), (48, 5), (49, 5), (50, 5);

-- ----------------------------
-- Records of the Authors table
-- ----------------------------
INSERT INTO public.authors (author) VALUES
    ('J.R.R. Tolkien'), ('J.K. Rowling'), ('Patrick Rothfuss'),
    ('George R.R. Martin'), ('Brandon Sanderson'), ('Terry Pratchett'),
    ('Scott Lynch'), ('Peter S. Beagle'), ('Andrzej Sapkowski'),
    ('Frank Herbert'), ('William Gibson'), ('Isaac Asimov'),
    ('Neal Stephenson'), ('Dan Simmons'), ('Ursula K. Le Guin'),
    ('Orson Scott Card'), ('H.G. Wells'), ('Liu Cixin'),
    ('Aldous Huxley'), ('Stieg Larsson'), ('Gillian Flynn'),
    ('Dan Brown'), ('Tana French'), ('Liane Moriarty'),
    ('Alex Michaelides'), ('Arthur Conan Doyle'), ('Agatha Christie'),
    ('A.J. Finn'), ('Jane Austen'), ('Nicholas Sparks'),
    ('Jojo Moyes'), ('Diana Gabaldon'), ('Julia Quinn'),
    ('Stephenie Meyer'), ('Sally Thorne'), ('Casey McQuiston'),
    ('Emily Henry'), ('Stephen King'), ('Bram Stoker'),
    ('Mary Shelley'), ('Shirley Jackson'), ('Josh Malerman'),
    ('William Peter Blatty'), ('Mark Z. Danielewski'), ('Thomas Harris');

-- ----------------------------
-- Records of the Book_Authors table
-- ----------------------------
INSERT INTO public.book_authors (id_book, id_author) VALUES
-- Fantasy
    (1, 1),  -- The Hobbit by J.R.R. Tolkien
    (2, 2),  -- Harry Potter by J.K. Rowling
    (3, 3),  -- The Name of the Wind by Patrick Rothfuss
    (4, 4),  -- A Game of Thrones by George R.R. Martin
    (5, 5),  -- Mistborn by Brandon Sanderson
    (6, 5),  -- The Way of Kings by Brandon Sanderson
    (7, 6),  -- Good Omens by Terry Pratchett
    (8, 7),  -- The Lies of Locke Lamora by Scott Lynch
    (9, 8),  -- The Last Unicorn by Peter S. Beagle
    (10, 9), -- The Witcher by Andrzej Sapkowski

-- Science Fiction
    (11, 10), -- Dune by Frank Herbert
    (12, 11), -- Neuromancer by William Gibson
    (13, 12), -- Foundation by Isaac Asimov
    (14, 13), -- Snow Crash by Neal Stephenson
    (15, 14), -- Hyperion by Dan Simmons
    (16, 15), -- The Left Hand of Darkness by Ursula K. Le Guin
    (17, 16), -- Ender's Game by Orson Scott Card
    (18, 17), -- The War of the Worlds by H.G. Wells
    (19, 18), -- The Three-Body Problem by Liu Cixin
    (20, 19), -- Brave New World by Aldous Huxley

-- Mystery
    (21, 20), -- The Girl with the Dragon Tattoo by Stieg Larsson
    (22, 21), -- Gone Girl by Gillian Flynn
    (23, 22), -- The Da Vinci Code by Dan Brown
    (24, 23), -- In the Woods by Tana French
    (25, 24), -- Big Little Lies by Liane Moriarty
    (26, 21), -- Sharp Objects by Gillian Flynn
    (27, 25), -- The Silent Patient by Alex Michaelides
    (28, 26), -- The Hound of the Baskervilles by Arthur Conan Doyle
    (29, 27), -- And Then There Were None by Agatha Christie
    (30, 28), -- The Woman in the Window by A.J. Finn

-- Romance
    (31, 29), -- Pride and Prejudice by Jane Austen
    (32, 30), -- The Notebook by Nicholas Sparks
    (33, 31), -- Me Before You by Jojo Moyes
    (34, 32), -- Outlander by Diana Gabaldon
    (35, 33), -- Bridgerton: The Duke and I by Julia Quinn
    (36, 34), -- Twilight by Stephenie Meyer
    (37, 35), -- The Hating Game by Sally Thorne
    (38, 36), -- Red, White & Royal Blue by Casey McQuiston
    (39, 37), -- Beach Read by Emily Henry
    (40, 37), -- People We Meet on Vacation by Emily Henry

-- Horror
    (41, 38), -- The Shining by Stephen King
    (42, 39), -- Dracula by Bram Stoker
    (43, 40), -- Frankenstein by Mary Shelley
    (44, 38), -- It by Stephen King
    (45, 41), -- The Haunting of Hill House by Shirley Jackson
    (46, 38), -- Pet Sematary by Stephen King
    (47, 42), -- Bird Box by Josh Malerman
    (48, 43), -- The Exorcist by William Peter Blatty
    (49, 44), -- House of Leaves by Mark Z. Danielewski
    (50, 45); -- The Silence of the Lambs by Thomas Harris

-- ----------------------------
-- Records of the Users table
-- ----------------------------
INSERT INTO public.user (email, roles, password) VALUES
    ('a@a.com', '["ROLE_ADMIN"]', '$2y$13$x7H1nrHrntcqSbXTJjFDLuIoaqbCrMeRM5Auugk4hh1OydfFAV6qS'),
    ('b@b.com', '["ROLE_USER"]', '$2y$13$x7H1nrHrntcqSbXTJjFDLuIoaqbCrMeRM5Auugk4hh1OydfFAV6qS'),
    ('c@c.com', '["ROLE_USER"]', '$2y$13$x7H1nrHrntcqSbXTJjFDLuIoaqbCrMeRM5Auugk4hh1OydfFAV6qS'),
    ('d@d.com', '["ROLE_USER"]', '$2y$13$x7H1nrHrntcqSbXTJjFDLuIoaqbCrMeRM5Auugk4hh1OydfFAV6qS'),
    ('e@e.com', '["ROLE_USER"]', '$2y$13$x7H1nrHrntcqSbXTJjFDLuIoaqbCrMeRM5Auugk4hh1OydfFAV6qS');

-- ----------------------------
-- Records of the User_Info table
-- ----------------------------
-- INSERT INTO public.user_info (name, surname, id_user) VALUES
--    ('James', 'Smith', 3),
--    ('Jack', 'Nobody', 2);

-- ----------------------------
-- Records of the Tags table
-- ----------------------------
INSERT INTO public.tags (tag) VALUES
    ('Magic'),
    ('Adventure'),
    ('Space'),
    ('Time Travel'),
    ('Detective'),
    ('Love'),
    ('Horror'),
    ('Fantasy World'),
    ('Technology'),
    ('Classic');

-- ----------------------------
-- Records of the Book_Tags table
-- ----------------------------
INSERT INTO public.book_tags (id_book, id_tag) VALUES
    (1, 8),  (1, 2),  -- The Hobbit (Fantasy World, Adventure)
    (2, 1),  (2, 8),  -- Harry Potter (Magic, Fantasy World)
    (3, 8),  (3, 2),  -- The Name of the Wind (Fantasy World, Adventure)
    (4, 8),  (4, 9),  -- A Game of Thrones (Fantasy World, Technology)
    (5, 8),  (5, 2),  -- Mistborn (Fantasy World, Adventure)
    (11, 3), (11, 9), -- Dune (Space, Technology)
    (12, 9), (12, 10), -- Neuromancer (Technology, Classic)
    (13, 9), (13, 3), -- Foundation (Technology, Space)
    (21, 5), (21, 7), -- The Girl with the Dragon Tattoo (Detective, Horror)
    (31, 6), (31, 10), -- Pride and Prejudice (Love, Classic)
    (41, 7), (41, 10); -- The Shining (Horror, Classic)