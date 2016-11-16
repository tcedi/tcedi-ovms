--   T.C.E.D.I. Open Visitors Management System
--   Copyright (c) 2016 by T.C.E.D.I. (Jean-Denis Tenaerts)
--
--   Licensed under the Apache License, Version 2.0 (the "License");
--   you may not use this file except in compliance with the License.
--   You may obtain a copy of the License at
--
--       http://www.apache.org/licenses/LICENSE-2.0
--
--   Unless required by applicable law or agreed to in writing, software
--   distributed under the License is distributed on an "AS IS" BASIS,
--   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
--   See the License for the specific language governing permissions and
--   limitations under the License.

-- Don't forget to change the name of the database and/or the table if required!

ALTER TABLE visitors MODIFY COLUMN Location VARCHAR(50);
ALTER TABLE visitors MODIFY COLUMN FirstName VARCHAR(255);
ALTER TABLE visitors MODIFY COLUMN LastName VARCHAR(255);
ALTER TABLE visitors MODIFY COLUMN Company VARCHAR(255);
ALTER TABLE visitors MODIFY COLUMN Visiting VARCHAR(255);
ALTER TABLE visitors MODIFY COLUMN Email VARCHAR(255);
ALTER TABLE visitors ADD COLUMN vehicleonsite INTEGER;
ALTER TABLE visitors ADD COLUMN licenseplate VARCHAR(25);
ALTER TABLE visitors MODIFY COLUMN Legal VARCHAR(10);
ALTER TABLE visitors MODIFY COLUMN inDate VARCHAR(30);
ALTER TABLE visitors MODIFY COLUMN outDate VARCHAR(30);

-- Conversion to UTF8
ALTER TABLE visitors MODIFY COLUMN Location CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE visitors MODIFY COLUMN FirstName CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE visitors MODIFY COLUMN LastName CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE visitors MODIFY COLUMN Company CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE visitors MODIFY COLUMN Visiting CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE visitors MODIFY COLUMN EMail CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE visitors MODIFY COLUMN licenseplate CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE visitors MODIFY COLUMN Legal CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE visitors MODIFY COLUMN inDate CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE visitors MODIFY COLUMN outDate CHARACTER SET utf8 COLLATE utf8_unicode_ci;

ALTER TABLE visitors DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

ALTER DATABASE reception DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
