#include "widget.h"

Widget::Widget(QWidget *parent)
    : QWidget(parent)

{
   // goBack=new QPushButton();
    //connect(goBack,SIGNAL(clicked(bool)),this,SLOT(goBackSlot()));

    getDone = false;
    hospitalName = "Елизаровская больница";
    this->setMinimumSize(640, 480);
    main_layout = new QHBoxLayout(this);
    manager = new QNetworkAccessManager(this);
    departments = QVector<Department>();
    //getDepartmentInfo();

    //while(!getDone);
    QFont font = QFont();
    font.setPointSize(16);

    //getdepartmentInfo fills departments

    listWidget = new QListWidget(this);
    listWidget->setFont(font);
    QVBoxLayout *left_layout = new QVBoxLayout(this);
    main_layout->addLayout(left_layout);
    //main_layout->addWidget(goBack);


    QLabel *dep_label = new QLabel("Отделения", this);
    dep_label->setMaximumHeight(30);
    dep_label->setFont(font);
    left_layout->addWidget(dep_label);

    left_layout->addWidget(listWidget);
    rightWidget = new RightWidget();
    main_layout->addWidget(rightWidget);

    //Будем контент менять
    listWidget->setItemSelected(listWidget->item(0), true);
    QWidget::connect(listWidget, SIGNAL(itemPressed(QListWidgetItem*)), this, SLOT(show_content(QListWidgetItem*)));
}

void Widget::getDepartmentInfo()
{
    QString Query="http://informcosm.temp.swtest.ru/get_scrubs_id.php";
    QUrl urlUser(Query);

    request = QNetworkRequest(urlUser);

    reply = manager->get(request);
    connect(reply, SIGNAL(finished()), this, SLOT(replyOnGetInfo()));

}
void Widget::setHospitalName(QString name)
{
    hospitalName = name;
    getDepartmentInfo();
}

void Widget::replyOnGetInfo()
{
    QNetworkReply *reply1 = qobject_cast<QNetworkReply *>(sender());
    QString content = reply1->readAll();
    if (content == "")
        return;
    parseScrubsInfo(content);
    getDepartmentNames();
}
void Widget::parseScrubsInfo(QString reply)
{
    //Переделать - получать id больницы от родительского окна-меню
    //Зачем? я получаю имя из окна-меню, а не айдишник.
    QStringList list = reply.split("&");
    for(int i = 0; i < list.size() - 1; i++)
    {
        QStringList sublist = list[i].split("|");
        if(sublist[1] == hospitalName)
        {
            SCRUBS_ID = sublist[0].toInt();
            break;
        }

    }

}

void Widget::parseDepartmentInfo(QString reply)
{
    QStringList departmentInfoList = reply.split("&");
    for (int i = 0; i < departmentInfoList.size()-1; i++)
    {
        QStringList depInfo = departmentInfoList[i].split("|");
        departments.push_back(Department());
        departments[i].id = depInfo[0].toInt();
        departments[i].name = depInfo[1];
        departments[i].busyNumber = depInfo[2].toInt();
        departments[i].bookedNumber = depInfo[3].toInt();
        departments[i].freeNumber = depInfo[4].toInt();
    }
    for (int i = 0; i < departments.size(); i++)
    {
        listWidget->addItem(departments[i].name);
    }
}

void Widget::getDepartmentNames()
{

    //TODO Ask Server for new bookings
    QString Query="http://informcosm.temp.swtest.ru/get_department_names.php?id=" + QString::number(SCRUBS_ID);


    //QUrl urlUser(Query);

    request = QNetworkRequest(QUrl(Query));

    reply = manager->get(request);

    connect(reply, SIGNAL(finished()), this, SLOT(replyOnDepartmentNames()));


}
void Widget::replyOnDepartmentNames()
{
    QNetworkReply *reply1 = qobject_cast<QNetworkReply *>(sender());
    QString content= reply1->readAll();
    if (content == "")
        return;
    parseDepartmentInfo(content);
}

void Widget::show_content(QListWidgetItem* t)
{
    //Определяем id в базе данных выделенного отделения и посылаем запрос к базе данных
    //чтобы обновить контент
    QString depName = t->text(); //Название отделения
    int depId;
    for (int i=0; i<departments.size(); i++)//Добываем id отделения ва базе
    {
        if (departments[i].name == depName)
        {
            depId=departments[i].id;
            break;
        }
    }
    //Перенаправляем действие кнопок правого меню на выделенное отделение
    rightWidget->department_id = depId;
    rightWidget->scrubs_id=SCRUBS_ID;
    //Обновляем информацию в правом меню
    rightWidget->RefreshTimerOverflow();

}

/*void Widget::goBackSlot(){
    this->hide();
    emit Hide();
}*/


Widget::~Widget()
{

}
