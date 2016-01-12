
Imports System.Net
Imports APICore
Imports System.Collections.Specialized
Imports System.IO
Imports System.Text

Public Class BaseController
    Public Function GetApiDataByUriJson(endpoints As Uri,
                                        Optional method As Enums.Method = Enums.Method.GetData,
                                        Optional data As String = Nothing) As String
        '                                Optional data As NameValueCollection = Nothing) As String




        Dim jsonres As String


        If method = Enums.Method.PostData Then
            jsonres = PostRequest(endpoints, data)

        Else
            Dim client = New WebClient()
            jsonres = client.DownloadString(endpoints)
            'jsonres = client.UploadString(endpoints, data)
            client.Dispose()

        End If


        Return jsonres
    End Function

    Private Function PostRequest(endpoints As Uri, data As String) As String
        ' Create a request using a URL that can receive a post. 
        Dim request As WebRequest = WebRequest.Create(endpoints)
        ' Set the Method property of the request to POST.
        request.Method = "POST"
        
        Dim byteArray As Byte() = Encoding.UTF8.GetBytes(data)
        ' Set the ContentType property of the WebRequest.
        request.ContentType = "application/x-www-form-urlencoded"
        ' Set the ContentLength property of the WebRequest.
        request.ContentLength = byteArray.Length
        ' Get the request stream.
        Dim dataStream As Stream = request.GetRequestStream()
        ' Write the data to the request stream.
        dataStream.Write(byteArray, 0, byteArray.Length)
        ' Close the Stream object.
        dataStream.Close()
        ' Get the response.
        Dim response As WebResponse = request.GetResponse()
        ' Display the status.
        Console.WriteLine(CType(response, HttpWebResponse).StatusDescription)
        ' Get the stream containing content returned by the server.
        dataStream = response.GetResponseStream()
        ' Open the stream using a StreamReader for easy access.
        Dim reader As New StreamReader(dataStream)
        ' Read the content.
        Dim responseFromServer As String = reader.ReadToEnd()
        ' Display the content.
        Console.WriteLine(responseFromServer)
        ' Clean up the streams.
        reader.Close()
        dataStream.Close()
        response.Close()

        Return responseFromServer
    End Function
End Class
