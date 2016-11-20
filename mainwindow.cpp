#include "mainwindow.h"

MainWindow::MainWindow(QWidget *parent)
    : QWidget(parent)
{
    this->setGeometry(500,100,350,600);

    manager=new QNetworkAccessManager(this);
    searchLine=new QLineEdit();
    searchLine->setFixedWidth(300);
    searchLine->setFixedHeight(20);

    QFont font =QFont();
    font.setPointSize(16);
    searchLine->setFont(font);
    searchResults=new QListWidget();
    searchResults->setFont(font);
    SetList();

    QGridLayout* mainLayout=new QGridLayout;

    mainLayout->addWidget(searchLine);
    mainLayout->addWidget(searchResults);
    this->setLayout(mainLayout);
    mainLayout->setContentsMargins(20,20,20,20);
    connect(searchLine,SIGNAL(textChanged(QString)),this,SLOT(ResultChanged(QString)));
    connect(manager, SIGNAL(finished(QNetworkReply*)),this, SLOT(replyFinished(QNetworkReply*)));
    connect(searchResults,SIGNAL(itemDoubleClicked(QListWidgetItem*)),this,SLOT(ChangeWindow(QListWidgetItem*)));
  //  connect(window,SIGNAL(Hide()),this,SLOT(Show()));
}


void MainWindow::SetList(){
    QString Query="http://informcosm.temp.swtest.ru/get_scrubs_id.php";
    QUrl urlUser(Query);
    request=QNetworkRequest(urlUser);
    reply= manager->get(request);
    connect( reply, SIGNAL(finished()),this, SLOT(replyFinished()));
}

void MainWindow::ResultChanged(QString res){

       if(res.length()>resPrev.length()){
        for(int i = 0; i < searchResults->count(); i++)
        {
            if(!searchResults->item(i)->text().contains(res))
            {
                searchResults->takeItem(i);
                i--;
            }
        }
    }
    else if(res.length()<resPrev.length()){
           if(!Contains(res) || res==""){
                 for(int i = 0; i < searchResultsCopy.size(); i++)
                 {
                     if(searchResultsCopy[i].contains(res) && !Contains(searchResultsCopy[i]))
                     {
                         searchResults->addItem(searchResultsCopy[i]);

                     }
                 }
           }
    }

    resPrev=res;

}

bool MainWindow::Contains(QString res){
   for(int i = 0; i < searchResults->count(); i++)
       {
          if(searchResults->item(i)->text().contains(res))
            {
                return true;
            }
        }

    return false;
}

void MainWindow::replyFinished(){
    QNetworkReply *reply1 = qobject_cast<QNetworkReply *>(sender());
    QString content= reply1->readAll();
    if (content == "")
        return;
    StringParser(content);
}

void MainWindow::StringParser(QString String){
    QStringList stringList = String.split("&");
    QVector<QStringList> strings;
    for(int i=0;i<stringList.length()-1;i++){
        strings.push_back(stringList[i].split("|"));
    }
    for(int i=0;i<strings.length();i++){
        searchResults->addItem(strings[i][1]);
        searchResultsCopy.push_back(strings[i][1]);
    }
}

void MainWindow::ChangeWindow(QListWidgetItem* item){
    //TODO: change window
    // window.setFixedSize(500,500);

    this->hide();
    window.setHospitalName(item->text());
    window.show();

}

/*void MainWindow::Show(){
    this->show();
}*/
