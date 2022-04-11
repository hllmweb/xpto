create database xpto;

use xpto;

/*
 * Usuários autenticados
 * */
create table  if not exists tb_Auth(
	IdAuth bigint not null auto_increment,
	Login varchar(50) not null,
	Password varchar(50) not null,
	Email varchar(100) not null,
	DtHrRegister datetime not null default now(),
	constraint email unique(Email),
	primary key(IdAuth)
);

-- criar uma tabela de logs de acesso 

drop table tb_Auth
select * from tb_Auth 
insert into tb_Auth (Login, Password, Email) values ('hllm',md5('123'),'hugomesquitaweb2@gmail.com');

drop table tb_LogAuth 
create table if not exists tb_LogAuth(
	IdLogAuth bigint not null auto_increment,
	IdAuth bigint not null,
	Login varchar(50) not null,
	DtHrRegister datetime not null default now(),
	primary key(IdLogAuth),
	constraint fk_auth_log
	foreign key(IdAuth) references tb_Auth(IdAuth)
);


/*
 * Url cadastradas associadas ao usuário cadastro
 * */
create table if not exists tb_Url(
	IdUrl bigint not null auto_increment,
	IdAuth bigint not null,
	Url varchar(50) not null,
	IpTerminal varchar(25) not null,
	DtHrRegister datetime not null default now(),
	primary key(IdUrl),
	constraint url unique(Url),
	constraint fk_auth_url
	foreign key(IdAuth) references tb_Auth(IdAuth)
);

-- fazer a checagem da url cadastrada
drop table tb_Url 
select * from tb_Url
insert into tb_Url (IdAuth, Url, IpTerminal) 
values (1, 'http://www.globo.com', '127.0.0.1');


drop table tb_Monitoring 
create table if not exists tb_LogMonitoring(
	IdMonitoring bigint not null auto_increment,
	IdUrl bigint not null,
	IdAuth bigint not null,
	StatusCode smallint not null,
	Body longtext not null,
	IpTerminal varchar(25) not null,
	DtHrMonitoring datetime not null default now(),
	primary key(IdMonitoring),
	constraint fk_url
	foreign key(IdUrl) references tb_Url(IdUrl),
	constraint fk_auth_monitoring
	foreign key(IdAuth) references tb_Auth(IdAuth)
);


drop trigger tg_alter_insert
create or replace trigger tg_after_insert
after insert on tb_Url
for each row 
begin
	insert into tb_LogMonitoring (IdUrl, IdAuth, StatusCode, IpTerminal) values (new.IdUrl, new.IdAuth, new.StatusCode, new.IpTerminal);
end;


drop trigger tg_after_update
create or replace trigger tg_after_insert 
after update on tb_Url
for each row 
begin
	if new.StatusCode <> old.StatusCode then
		update tb_Url set StatusCode = new.StatusCode, Body = new.Body
		where IdUrl = old.IdUrl;
	end if; 
end;

-- retornando o último registro relacionado ao usuário
select u.Url, m.StatusCode, max(m.DtHrMonitoring) as DtHrMonitoring from tb_Url u 
join tb_LogMonitoring m on m.IdUrl = u.IdUrl and m.IdAuth = u.IdAuth
join tb_Auth a on a.IdAuth = m.IdAuth
where a.Login = 'hx'


-- (Correto)
-- retornando o último registro relacionado ao usuário
select u.Url, m.StatusCode, max(m.DtHrMonitoring) as DtHrMonitoring  from tb_Auth a 
join tb_Url u on u.IdAuth = a.IdAuth 
join tb_LogMonitoring m on m.IdUrl = u.IdUrl and m.IdAuth = a.IdAuth 
where a.Login = 'hllm' group by u.Url, m.StatusCode




DATE_FORMAT(SYSDATE(), '%Y-%m-01')

select * from tb_LogMonitoring
insert into tb_LogMonitoring (IdUrl, IdAuth, StatusCode, Body, IpTerminal) values (1,1,'300','sadahsudhasudhasudhaushdaus','127.0.0.1');



create or replace trigger tg_url_update
after update on tb_Url
for each row 
begin
	if new.StatusCode <> old.StatusCode then 
		insert into tb_Monitoring () values ();
	end if;
end;
