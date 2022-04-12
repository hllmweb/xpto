create database xpto;

use xpto;

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
	Url varchar(150) not null,
	IpTerminal varchar(25) not null,
	DtHrRegister datetime not null default now(),
	primary key(IdUrl),
	constraint fk_auth_url
	foreign key(IdAuth) references tb_Auth(IdAuth)
);

-- fazer a checagem da url cadastrada
drop table tb_Url 
select * from tb_Url
insert into tb_Url (IdAuth, Url, IpTerminal) 
values (1, 'http://www.hugomesquita.com.br', '127.0.0.1');


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

select * from tb_LogMonitoring

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
select a.IdAuth, u.Url, m.StatusCode, m.Body, max(m.DtHrMonitoring) as DtHrMonitoring  from tb_Auth a 
join tb_Url u on u.IdAuth = a.IdAuth 
left join tb_LogMonitoring m on m.IdUrl = u.IdUrl and m.IdAuth = a.IdAuth 
where 
((1 = 1) and (a.IdAuth = 1))
or 
((0 = 1))

group by a.IdAuth, u.Url, m.StatusCode




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
	 * 0 = verifica se existe email, caso não exista, efetua o cadastro
	 * */
	
	 case p_operacao
		 when 0 then
			if (select fn_email(p_email)) = 1 then 
				select 1 valor;  -- "E-Mail Já Cadastrado!"
			else
		 		select 0 valor;  -- "E-Mail Não Cadastrado!" 
		 	end if;
			

		when 1 then
			select "teste1" mensagem;
		when 2 then 
			select "teste2" mensagem;
	end case;
end;

end//

call sp_auth(0,'teste', '1112', 'jack@gmail.com') 




/* realizar o insert do monitoramento*/
create procedure if not exists sp_monitoring(
	p_operacao int,
	p_opcao int,
	p_idauth bigint,
	p_idurl bigint,
	p_statuscode smallint, 
	p_body longtext,
	p_ipterminal varchar(25)
)
begin
	/* p_opcao = 1 (lista apenas urls do id)
	 * p_opcao = 0 (lista todas as urls)]
	 * 
	 * 0 = lista urls em monitoramento por usuários
	 * 1 = insere o status code e body de cada requisição
	 * */
	case p_operacao
		when 0 then
			select a.IdAuth, u.Url, m.StatusCode, m.Body, max(m.DtHrMonitoring) as DtHrMonitoring  from tb_Auth a 
			join tb_Url u on u.IdAuth = a.IdAuth 
			left join tb_LogMonitoring m on m.IdUrl = u.IdUrl and m.IdAuth = a.IdAuth 
			where 
			((1 = p_opcao) and (a.IdAuth = p_idauth))
				or 
			((0 = p_opcao))
			group by a.IdAuth, u.Url, m.StatusCode;

		when 1 then
			insert into tb_LogMonitoring (idUrl, IdAuth, StatusCode, Body, IpTerminal) 
		 	values (p_idurl, p_idauth, p_statuscode, p_body, p_ipterminal);
	end case;
end;


select * from tb_LogMonitoring
call sp_monitoring(0,1,1,null,null,null,null);
call sp_monitoring(0,0,null,null,null,null,null);
call sp_monitoring(1,null,1,1,200,'dashudashu','127.0.0.1');

/*else
		 		insert into tb_Auth (Login, Password, Email) values (p_login, p_password, p_email);
		 		select "E-Mail Cadastrado com Sucesso!" mensagem;*/


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
	 		 	set v_result = 1; -- 'E-Mail Já Existe!';
	 		else
	 			set v_result = 0; -- 'E-Mail Não Existe!';
	 		end if;
	 
	 	close cursor_acesso;
	return (v_result);
end;

end//

select fn_email('xxx@gmail.com') as result;










			-- if exists (select var_email) then 
			-- 	select "E-Mail Já Cadastrado!" mensagem;
			-- else 
				-- insert into tb_Auth (Login, Password, Email) values (p_login, p_password, p_email);
				-- select "E-Mail Cadastrado com Sucesso!" mensagem;
			-- end if;
