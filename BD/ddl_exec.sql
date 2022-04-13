create database xpto;
use xpto;

drop table tb_Auth

/*
 * Usuários autenticados
 * */
create table  if not exists tb_Auth(
	IdAuth bigint not null auto_increment,
	Login varchar(50) not null,
	Password varchar(50) not null,
	Email varchar(150) not null,
	DtHrRegister datetime not null default now(),
	constraint email unique(Email),
	primary key(IdAuth)
);

select * from tb_Auth 
insert into tb_Auth (Login, Password, Email) values 
('xxx',md5('123'),'xxx@gmail.com'),
('yyy',md5('123'),'yyy@gmail.com');


/*
 * Url cadastradas associadas ao usuÃ¡rio cadastro
 * */
create table if not exists tb_Url(
	IdUrl bigint not null auto_increment,
	IdAuth bigint not null,
	StatusCode smallint null,
	Url varchar(250) not null,
	IpTerminal varchar(25) not null,
	DtHrRegister datetime not null default now(),
	primary key(IdUrl),
	constraint fk_auth_url
	foreign key(IdAuth) references tb_Auth(IdAuth)
);


insert into tb_Url (IdAuth, Url, IpTerminal) 
values (2, 'https://www.globo.com', '127.0.0.1');

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
	foreign key(IdUrl) references tb_Url(IdUrl) on delete cascade on update cascade,
	constraint fk_auth_monitoring
	foreign key(IdAuth) references tb_Auth(IdAuth) on delete cascade on update cascade
);


/*importante para atualizar o status*/
drop trigger tg_after_insert
create or replace trigger tg_after_insert 
after insert on tb_LogMonitoring
for each row 
begin
	update tb_Url set StatusCode = new.StatusCode
	where IdUrl = new.IdUrl and IdAuth = new.IdAuth;
end;

call sp_auth(1, 'yyy','23',null)
drop procedure sp_auth 

delimiter //
/*Stored Procedure*/
create procedure  if not exists sp_auth(
	p_operacao int,
	p_login varchar(50),
	p_password varchar(50),
	p_email varchar(100)
) 
begin
	/*	
	 * 
	 * p_operacao = 0 (verifica se existe email, caso não exista, efetua o cadastro)
	 * p_operacao = 1 (verifica se existe usuário)
	 * p_operacao = 2 (inserir usuários)
	 * */
	
	 case p_operacao
		 when 0 then
			if (select fn_email(p_email)) = 1 then 
				select 1 valor;  -- "E-Mail Já Cadastrado!"
			else
		 		select 0 valor;  -- "E-Mail Não Cadastrado!" 
		 	end if;
		when 1 then
		
			if not exists (select 1 from tb_Auth a where a.Login = p_login and a.Password  = md5(p_password)) then 
				select 0 valor; -- "Usuário ou Senha invalido!"
			else 
				select a.IdAuth, a.Login, a.Password, a.Email, a.DtHrRegister 
				from tb_Auth a where a.Login = p_login and a.Password  = md5(p_password);
			end if;
			
		when 2 then 
				insert into tb_Auth (Login, Password, Email) values (p_login, md5(p_password), p_email);
				select 'Cadastrado com sucesso!' mensagem;
	end case;
end;


/* realizar o insert do monitoramento*/
create procedure if not exists sp_monitoring(
	p_operacao int,
	p_opcao int,
	p_idauth bigint,
	p_idurl bigint,
	p_url varchar(250),
	p_statuscode smallint, 
	p_body longtext,
	p_ipterminal varchar(25)
)
begin
	/* p_opcao = 1 (lista apenas urls do id)
	 * p_opcao = 0 (lista todas as urls)
	 * 
	 * 
	 * p_operacao = 0 (lista urls em monitoramento por usuários)
	 * p_operacao = 1 (insere o status code e body de cada requisições)
	 * p_operacao = 2 (delete url e o log de monitoramento)
	 * p_operacao = 3 (insere url)
	 * */
	case p_operacao
		when 0 then
			select a.IdAuth, u.IdUrl, u.Url, u.StatusCode,
			m.Body, max(m.DtHrMonitoring) as DtHrMonitoring from tb_Auth a 
			join tb_Url u on u.IdAuth = a.IdAuth 
			left join tb_LogMonitoring m on m.IdUrl = u.IdUrl and m.IdAuth = a.IdAuth 
			where 
			((1 = p_opcao) and (a.IdAuth = p_idauth))
			or 
			((0 = p_opcao))
			group by a.IdAuth, u.StatusCode, u.IdUrl, u.Url;
	
		when 1 then
			insert into tb_LogMonitoring (idUrl, IdAuth, StatusCode, Body, IpTerminal) 
		 	values (p_idurl, p_idauth, p_statuscode, p_body, p_ipterminal);
		 	select 1 valor;
		when 2 then
		 	delete from tb_Url where IdAuth = p_idauth and IdUrl = p_idurl; 
		 	select 1 valor;
		when 3 then 
			insert into tb_Url (IdAuth, Url, IpTerminal) 
			values (p_idauth, p_url, p_ipterminal);
			select 1 valor;
	end case;
end;

end//




/* função que verifica se já existe o email*/

delimiter //
create function fn_email(
	p_email varchar(100)
)
returns varchar(100)

begin
	declare final int default 0;
	declare v_result int;
	declare v_email varchar(100);
	

	declare cursor_acesso cursor for 
		select Email from tb_Auth where Email = p_email;
			
		declare continue handler for not found set final = 1;
				
	 	open cursor_acesso;
	 		fetch cursor_acesso into v_email;
	 		if not final then 
	 		 	set v_result = 1; -- 'E-Mail JÃ¡ Existe!';
	 		else
	 			set v_result = 0; -- 'E-Mail NÃ£o Existe!';
	 		end if;
	 
	 	close cursor_acesso;
	return (v_result);
end;

end//

select fn_email('zzz@gmail.com') as result;













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



-- retornando o Ãºltimo registro relacionado ao usuÃ¡rio
select u.Url, m.StatusCode, max(m.DtHrMonitoring) as DtHrMonitoring from tb_Url u 
join tb_LogMonitoring m on m.IdUrl = u.IdUrl and m.IdAuth = u.IdAuth
join tb_Auth a on a.IdAuth = m.IdAuth
where a.Login = 'hx'


-- (Correto)
-- retornando o Ãºltimo registro relacionado ao usuÃ¡rio
select a.IdAuth, u.IdUrl, u.Url, m.Body, m.StatusCode,
(select lm.StatusCode from tb_LogMonitoring lm 
where lm.IdUrl = u.IdUrl and lm.IdAuth = a.IdAuth order by lm.DtHrMonitoring desc limit 1) as StatusCode, 
max(m.DtHrMonitoring) as DtHrMonitoring  from tb_Auth a 
join tb_Url u on u.IdAuth = a.IdAuth 
left join tb_LogMonitoring m on m.IdUrl = u.IdUrl and m.IdAuth = a.IdAuth 
where 
((1 =1) and (a.IdAuth = 2))
or 
((0 = 1))
group by a.IdAuth, u.IdUrl, u.Url


select lm.StatusCode from tb_LogMonitoring lm 
where lm.IdUrl = 1 and lm.IdAuth = 1 order by lm.DtHrMonitoring desc limit 1 

DATE_FORMAT(SYSDATE(), '%Y-%m-01')
drop table tb_LogMonitoring
select * from tb_LogMonitoring
insert into tb_LogMonitoring (IdUrl, IdAuth, StatusCode, Body, IpTerminal) values (1,1,'200','sadahsudhasudhasudhaushdaus','127.0.0.1');

insert into tb_LogMonitoring (IdUrl, IdAuth, StatusCode, Body, IpTerminal) values (3,4,'200','sadahsudhasudhasudhaushdaus','127.0.0.1');


create or replace trigger tg_url_update
after update on tb_Url
for each row 
begin
	if new.StatusCode <> old.StatusCode then 
		insert into tb_Monitoring () values ();
	end if;
end;


























use xpto;
drop procedure sp_auth
drop procedure sp_monitoring 
drop function fn_email


call sp_auth(0,'teste', '1112', 'jack@gmail.com') 


drop procedure sp_monitoring






select * from tb_Url where IdUrl = 7

select * from tb_LogMonitoring
call sp_monitoring(0,1,2,null,null,null,null);
call sp_monitoring(0,0,null,null,null,null,null);
call sp_monitoring(1,null,1,1,200,'dashudashu','127.0.0.1');
call sp_monitoring(2,null,7,null,null,null,null);
call sp_monitoring(3,null,2,null,'http://www.techmonteiro.com.br',null,null,'127.0.0.1');

/*else
		 		insert into tb_Auth (Login, Password, Email) values (p_login, p_password, p_email);
		 		select "E-Mail Cadastrado com Sucesso!" mensagem;*/











			-- if exists (select var_email) then 
			-- 	select "E-Mail JÃ¡ Cadastrado!" mensagem;
			-- else 
				-- insert into tb_Auth (Login, Password, Email) values (p_login, p_password, p_email);
				-- select "E-Mail Cadastrado com Sucesso!" mensagem;
			-- end if;
