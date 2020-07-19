

//        var generator = [
//            '{{repeat(10, 10)}}',
//            {
//                id: 0,
//                first_name: '{{firstName()}}',
//                last_name: '{{surname()}}',
//                dob: '{{date(new Date(1970, 0, 1), new Date(2010, 0, 1), "YYYY-MM-dd")}}',
//                contact: '+91 {{phone()}}'
//            }
//        ];
//        var json = '[{"id":0,"first_name":"Flora","last_name":"Oneil","dob":"1989-02-10","contact":"+91 (940) 575-3087"},{"id":0,"first_name":"Gilliam","last_name":"Gillespie","dob":"1985-02-13","contact":"+91 (894) 548-2107"},{"id":0,"first_name":"Myers","last_name":"Lee","dob":"1994-09-07","contact":"+91 (949) 460-3648"},{"id":0,"first_name":"Minnie","last_name":"Ortiz","dob":"1987-11-17","contact":"+91 (854) 578-2995"},{"id":0,"first_name":"Ila","last_name":"Reese","dob":"1972-04-09","contact":"+91 (806) 570-2515"},{"id":0,"first_name":"Rocha","last_name":"Roach","dob":"1982-03-09","contact":"+91 (904) 576-3347"},{"id":0,"first_name":"Riley","last_name":"Kent","dob":"1997-06-29","contact":"+91 (838) 485-3446"},{"id":0,"first_name":"Lucy","last_name":"Christian","dob":"2009-03-04","contact":"+91 (836) 525-2442"},{"id":0,"first_name":"Cotton","last_name":"Adams","dob":"1998-04-02","contact":"+91 (913) 587-2069"},{"id":0,"first_name":"Valeria","last_name":"Deleon","dob":"1978-10-27","contact":"+91 (864) 532-2215"}]';
//        var tempList = JSON.parse(json);
//        for(let i=0;i<10;i++){
//            post('c=student&a=add', tempList[i]).then(function (data) {
//                console.log('saveModelData', data);
//            });
//        }